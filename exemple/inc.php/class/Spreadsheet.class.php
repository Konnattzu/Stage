<?php
    class Spreadsheet{
        public $header = Array();
        public $identifier = Array();
        public $row = Array();
        public $column = Array();
        public $cells = Array();
        public $bddtable = "step2";
        public $bddbase = "step1";

        public function __construct($file, $pdo){
            $this->headerSet($file);
            $this->dataSet($file, $this->header, $pdo);
            $this->idSet($this->cells);
            $this->rowSet($this->identifier, $this->header, $this->cells);
            $this->colSet($this->header, $this->identifier, $this->cells);
        }

        public function headerSet($file){
			$filehead = array_shift($file);
            for($j=0;$j<count($filehead);$j++){
                $this->header[$j] = new Header($filehead[$j], $j);
            }
        }
        public function setHeader(){
            $this->header = $header;
        }
        public function getHeader(){
            return $this->header;
        }

        public function dataSet($file, $header, $pdo){
			unset($file[0]);
            $row=0;
            for($j=0;$j<count($header);$j++){
                $this->cells[$j] = Array();
            }
            foreach ($file as $col) {
				$this->cells[0][$row] = new Cell($col[0], $row, 0, $header[0]->getValue(), $col[0], $pdo);
                for($j=1;$j<count($header);$j++){
                    $this->cells[$j][$row] = new Cell($col[$j], $row, $j, $header[$j]->getValue(), $this->cells[0][$row]->getValue(), $pdo);
                }
                $row++;
            }
        }
        public function setCell(){
            $this->header = $header;
        }
        public function getCell(){
            return $this->cells;
        }

        public function idSet($cells){
            for($j=0;$j<count($cells[0])-1;$j++){
                $this->identifier[$j] = new Identifier($cells[0][$j+1], $j);
            }
        }
        public function setId(){
            $this->header = $header;
        }
        public function getId(){
            return $this->identifier;
        }

        public function rowSet($identifier, $header, $cells){
            for($j=0;$j<count($identifier);$j++){
                for($i=0;$i<count($header);$i++){
                    $tempcells[$i] = $cells[$i][$j];
                }
                $this->row[$j] = new Row($identifier[$j], $j, $tempcells);
            }
        }
        public function setRow(){
            $this->header = $header;
        }
        public function getRow(){
            return $this->row;
        }

        public function colSet($header, $identifier, $cells){
            for($j=0;$j<count($header);$j++){
                for($i=0;$i<count($identifier);$i++){
                    $tempcells[$i] = $cells[$j][$i];
                }
                $this->column[$j] = new Column($header[$j]->getValue(), $j, $tempcells);
            }
        }
        public function setCol(){
            $this->column = $column;
        }
        public function getCol(){
            return $this->column;
        }

        public function setBdTab($bddtable){
            $this->bddtable = $bddtable;
        }
        public function getBdTab(){
            return $this->bddtable;
        }

        public function setBdB($bddbase){
            $this->bddbase = $bddbase;
        }
        public function getBdB(){
            return $this->bddbase;
        }

        public function createTable($pdo){
            $query = 'CREATE TABLE IF NOT EXISTS '.$this->bddtable.' LIKE '.$this->bddbase.';';
            $pdo->exec($query);
        }
        public function addData($file, $pdo){

            //récupérer header table 1
			$basetable = new BDDsheet($pdo);
            $infotable = $pdo->prepare('SHOW COLUMNS FROM '.$this->bddbase.';');
			$infotable->execute();
            $i=0;
			while($infos = $infotable->fetch(PDO::FETCH_ASSOC)){
				preg_match('/\d+/', $infos['Type'], $len);
				if(!isset($len[0]) || $len[0] == ""){
					$len = "";
				}
				$basetable->setHeader(new Header($infos["Field"], $i, $infos["Type"], $len), $i);
				$i++;
			}
			
            //si table 2 plus grande que table 1
			if(count($this->header) >= count($basetable->header)){
				$righthead = Array();
				for($i=0;$i<count($basetable->header);$i++){
					if($this->header[$i] != $basetable->header[$i]){
						$matching = 50;
						$overflow = 0;
						$coltype = preg_replace("/[^A-Za-z]/", "", $basetable->header[$i]->getType());
						$collen = $string = preg_replace("/[^0-9]/", "", $basetable->header[$i]->getType());
						for($k=0;$k<count($this->header);$k++){
							$headtype = "";
							$headlen = 0;
							for($j=0;$j<count($this->row);$j++){
								$occupied = false;
								if(!empty($this->cells[$k][$j]->value)){
									$headtype = datatype($this->cells[$k][$j]->value, $headtype, $headlen);
									$headlen = datalength($this->cells[$k][$j]->value, $headtype, $headlen);
                                    $this->cells[$k][$j]->setType($headtype);
                                    $this->cells[$k][$j]->setLen($headlen);
								}
							}
                            $this->column[$k]->setType($this->cells[$k][count($this->cells[$k])-1]->getType());
                            $this->column[$k]->setLen($this->cells[$k][count($this->cells[$k])-1]->getLen());
							$this->header[$k]->setType($this->cells[$k][count($this->cells[$k])-1]->getType());
                            $this->header[$k]->setLen($this->cells[$k][count($this->cells[$k])-1]->getLen());
							
				
							if($this->header[$k]->getType() == $basetable->header[$k]->getType()){
								similar_text($this->header[$k]->getValue(), $basetable->header[$k]->getValue(), $perc);
								if($matching < $perc){
									for($r=0;$r<count($this->header);$r++){
										if(isset($righthead[$r]) && $righthead[$r] == $this->header){
											$occupied = true;
										}
									}
									if($occupied == false){
										$righthead[$i] = $basetable->header[$k];
										$matching = $perc;
									}
						
								}
							}
						}
						
					}else{
						$righthead[$i] = $basetable->header[$i];
					}
				}
				for($i=0;$i<count($this->header);$i++){
					if(isset($righthead[$i])){
						$this->header[$i] = $righthead[$i];
					}else{
						$overflow++;
						$righthead[$i] = $this->header[count($column)-1 + $overflow];
						for($k=count($column);$k<count($this->header);$k++){
							$column[$k] = $righthead[$k];
							$header[$k] = $righthead[$k];
							$headtype = "";
							$headlen = 0;
							for($l=0;$l<count($this->row);$l++){
								if(!empty($this->cells[$k][$j]->value)){
									$headtype = datatype($this->cells[$k][$j]->value, $headtype, $headlen);
									$headlen = datalength($this->cells[$k][$j]->value, $headtype, $headlen);
									$this->cells[$i][$j]->setType($headtype);
									$this->cells[$i][$j]->setLen($datalength);
								}
							}
                            $this->column[$k]->setType($this->cells[$k][count($this->cells[$k])-1]->getType());
                            $this->column[$k]->setLen($this->cells[$k][count($this->cells[$k])-1]->getLen());
							$this->header[$k]->setType($this->cells[$k][count($this->cells[$k])-1]->getType());
                            $this->header[$k]->setLen($this->cells[$k][count($this->cells[$k])-1]->getLen());
                            $req = $pdo->prepare('ALTER TABLE step2 ADD '.$this->header[$k].' '.$headtype.' ('.$headlen.');');
                            $req->execute();
						}
					}
					
				}

            //si table 1 plus grande que table 2
			}
			
			echo'<pre>';
			print_r($this);
			echo'</pre>';

			echo'<pre>';
			print_r($basetable);
			echo'</pre>';


		//else if(count($this->header) <= count($column)){
				
		// 		$rightcol = Array();
		// 		for($i=0;$i<count($this->header);$i++){
		// 			if($this->header[$i] != $column[$i]){
		// 				$matching = 0;
		// 				for($k=0;$k<count($column);$k++){
		// 					$type[$k] = preg_replace("/[^A-Za-z]/", "", $coltype[$k]);
		// 					$len[$k] = $string = preg_replace("/[^0-9]/", "", $coltype[$k]);
		// 					$datatype[$i] = "";
		// 					$datalength[$i] = 0;
		// 					for($j=0;$j<count($this->row);$j++){
		// 							$occupied = false;
								
		// 						if(!empty($array[$nbcol[$i]][$j])){
		// 							$this->cells[$i][$j]->datatype = datatype($array[$nbcol[$i]][$j], $datatype[$i], $datalength[$i]);
		// 							$this->cells[$i][$j]->datalength = datalength($array[$nbcol[$i]][$j], $datatype[$i], $datalength[$i]);
		// 						}
		// 					}
		// 					if($datatype[$i] == $type[$k]){
		// 						similar_text($this->header[$i], $column[$k], $perc);
		// 						if($matching < $perc){
		// 							for($r=0;$r<count($this->header);$r++){
		// 								if(isset($rightcol[$r]) && $rightcol[$r] == $k){
							
		// 									$occupied = true;
		// 								}
										
		// 							}
									
		// 							if($occupied == false){
		// 								$rightcol[$i] = $k;
										
		// 								$matching = $perc;
		// 							}
						
		// 						}
		// 					}
							
							
		// 				}
		// 				if(isset($rightcol[$i])){
		// 					$this->header[$i] = $column[$rightcol[$i]];
		// 				}
		// 			}
		// 		}				
		// 	}
			
			for($j=0;$j<count($this->row);$j++){
				$querydata[$j] = "INSERT INTO step2 (";
				for($i=0;$i<count($this->header);$i++){
					if($this->header[$i]->getValue() != ""){
						$querydata[$j] .= $this->header[$i]->getValue().", ";
					}else{
						$querydata[$j] .= "colonne".$i.", ";						
					}
				}
				$querydata[$j][strlen($querydata[$j])-2] = " ";
				$querydata[$j][strlen($querydata[$j])-1] = " ";
				$querydata[$j] = rtrim($querydata[$j]);
				$querydata[$j] .= ") VALUES (";
				for($i=0;$i<count($this->header);$i++){
					$type = preg_replace("/[^A-Za-z]/", "", $righthead[$i]->getType());
					$len = $string = preg_replace("/[^0-9]/", "", $righthead[$i]->getLen());
					$this->cells[$i][$j]->setType(datatype($this->cells[$i][$j]->value, $type, $len));
					$this->cells[$i][$j]->setLen(datalength($this->cells[$i][$j]->value, $type, $len));
					if($this->cells[$i][$j]->getType() == "date"){
						$this->cells[$i][$j]->value = date_format(date_create_from_format($datalength[$i], $array[$nbcol[$i]][$j]), "Y-m-d");
					}
					if(!empty($this->header[$i][$j]->getLen()) && $this->header[$i][$j]->getLen() > $basetable->header[$i][$j]->getLen()){
                        $req = $pdo->prepare('ALTER TABLE step2 MODIFY '.$this->header[$i]->getValue().' '.$this->header[$i]->getType().' ('.$this->header[$i]->getLen().');');
                        $req->execute();
					}
				}
				for($i=0;$i<count($this->header);$i++){
					if($this->header[$i]->getType() == "boolean"){
						$this->cells[$i][$j]->setValue(str_replace("oui", "1", $this->cells[$i][$j]->getValue()));	
						$this->cells[$i][$j]->setValue(str_replace("non", "0", $this->cells[$i][$j]->getValue()));	
						if(empty($this->cells[$i][$j]->getValue())){
							$this->cells[$i][$j]->setValue("0");
						}
					}
					if($this->header[$i]->getType() == "date"){
						if(!empty($this->cells[$i][$j]->getValue())){
							$querydata[$j] .= "'".$this->cells[$i][$j]->getValue()."', ";	
						}
					}else{
						if(!empty($this->cells[$i][$j]->getValue())){
							$querydata[$j] .= "'".$this->cells[$i][$j]->getValue()."', ";	
						}else{
							$querydata[$j] .= "NULL, ";
						}
					}
				}
				$querydata[$j] .= ");";
				for($i=1;$i<=3;$i++){
					$querydata[$j][strlen($querydata[$j])-$i] = " ";
				}
				$querydata[$j][strlen($querydata[$j])-3] = ";";
				$querydata[$j][strlen($querydata[$j])-4] = ")";
				
				$identifier = $this->identifier[$j];
				$idvalue = $this->cells[0][$j]->getValue();
				$simi = similar_text($this->header[0], $this->header[0]);
				for($i=0;$i<count($this->header);$i++){
					if(similar_text($this->header[$i], $this->header[0] > $simi)){
						$simi = similar_text($this->header[$i], $this->header[0]);
						$identifier = $this->header[$i];
						$idvalue = $array[$nbcol[$i]][$j];
					}
				}
				echo $querydata[$j];
                $req = $pdo->prepare($querydata[$j]);
                $req->execute();
			}
            print_r($querydata);
        }
    }
?>