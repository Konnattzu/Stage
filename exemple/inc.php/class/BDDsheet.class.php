<?php
    class BDDsheet{
        public $header = Array();
        public $identifier = Array();
        public $row = Array();
        public $column = Array();
        public $cells = Array();
        public $bddtable = "step1";

        public function __construct($pdo){
            // $this->headerSet($file);
            // $this->dataSet($file, $this->header);
            // $this->idSet($this->cells);
            // $this->rowSet($this->identifier, $this->header, $this->cells);
            // $this->colSet($this->header, $this->identifier, $this->cells);
        }

        public function headerSet($file){
			$filehead = array_shift($file);
            for($j=0;$j<count($filehead);$j++){
                $this->header[$j] = new Header($filehead[$j], $j);
            }
        }
        public function setHeader($header, $pos){
            $this->header[$pos] = $header;
        }
        public function getHeader(){
            return $this->header;
        }

        public function dataSet($file, $header){
            $row=0;
            for($j=0;$j<count($header);$j++){
                $this->cells[$j] = Array();
            }
            foreach ($file as $col) {
                for($j=0;$j<count($header);$j++){
                    $this->cells[$j][$row] = new Cell($col[$j], $row, $j);
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
            for($j=0;$j<count($cells[0]);$j++){
                $this->identifier[$j] = new Identifier($cells[0][$j], $j);
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
                    $tempcells[$j] = $cells[$i][$j];
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
                    $tempcells[$j] = $cells[$j][$i];
                }
                $this->column[$j] = new Column($header[$j]->getValue(), $j, $tempcells);
            }
        }
        public function setCol(){
            $this->header = $header;
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

        public function createTable($bddtable, $file){
            $querytable = "CREATE TABLE IF NOT EXISTS ".$bddtable."
			 (";
			for($i=0;$i<count($this->header);$i++){
				$datalength = 0;
				$datatype = "";
				$header[$i] = clear($header[$i]);
				if($header[$i] == ""){
					$querytable .= 'colonne'.$i.' ';
				}else{
					$querytable .= $header[$i].' ';
				}
				$enum = Array();
				for($j=0;$j<$row;$j++){
					if($array[$nbcol[$i]][$j] != ""){
						$enum[count($enum)] = $array[$nbcol[$i]][$j];
						if(count($enum)>0){
							for($k=0;$k<count($enum)-1;$k++){
								if($enum[$k] == $array[$nbcol[$i]][$j]){
									unset($enum[count($enum)-1]);
								}
							}
						}
					}
					$datalength = datalength($array[$nbcol[$i]][$j], $datatype, $datalength);
					$datatype = datatype($array[$nbcol[$i]][$j], $datatype, $datalength);
					if(($datatype == "boolean") && ($array[$nbcol[$i]][$j] != "oui") && ($array[$nbcol[$i]][$j] != "non") && ($array[$nbcol[$i]][$j] != "1") && ($array[$nbcol[$i]][$j] != "0")){
						$comment = preg_replace("/(oui|non|1|0)/", " ", $array[$nbcol[$i]][$j]);
						$comment = trim($comment);
						$array[$nbcol[$i]][$j] == str_replace($comment, " ", $array[$nbcol[$i]][$j]);
						$array[$nbcol[$i]][$j] == trim($array[$nbcol[$i]][$j]);
						}
				}
				if(count($array[0])>16){
					if(count($enum)<8 && $datatype != "boolean"){
						$datatype = "enum";
						$datalength = "";
						for($k=0;$k<count($enum)-1;$k++){
							$datalength .= "'".$enum[$k]."', ";
						}
						$datalength .= "'".$enum[$k]."'";
					}
				}else{
					if(count($enum)<(count($array[0])*0.75) && $datatype != "boolean"){
						$datatype = "enum";
						$datalength = "";
						for($k=0;$k<count($enum)-1;$k++){
							$datalength .= "'".$enum[$k]."', ";
						}
						$datalength .= "'".$enum[$k]."'";
					}
				}
				if(($datatype != "date") && ($datatype != "boolean")){
					$datatype .= "(";
				}
				if(preg_match("/[(]/", $datatype)){
					$querytable .= $datatype.''.$datalength.'), ';
				}else{
					$querytable .= $datatype.', ';
				}
			}
			$querytable .= ');';
			for($i=1;$i<=3;$i++){
				$querytable[strlen($querytable)-$i] = " ";
			}
			$querytable[strlen($querytable)-3] = ";";
			$querytable[strlen($querytable)-4] = ")";
			mysqli_query($mysqli, $querytable);
		}
		public function addData($file){
			$infotable = mysqli_query($_SESSION["mysqli"], 'SELECT 
									TABLE_CATALOG,
									TABLE_SCHEMA,
									TABLE_NAME, 
									COLUMN_NAME, 
									DATA_TYPE, 
									COLUMN_TYPE, 
									CHARACTER_MAXIMUM_LENGTH
									FROM INFORMATION_SCHEMA.COLUMNS
									where TABLE_NAME = "step2";');
									$i = 0;
									$datatype = Array();
									$datalength = Array();
			while($infos = $infotable->fetch_assoc()){
				$column[$i] = $infos["COLUMN_NAME"];
				$coltype[$i] = $infos["COLUMN_TYPE"];
				$charlength[$column[$i]] = $infos["CHARACTER_MAXIMUM_LENGTH"];
				$i++;
			}
			
			if(count($header) >= count($column)){
				$rightcol = Array();
				for($i=0;$i<count($column);$i++){
					
					if($header[$i] != $column[$i]){
						$matching = 50;
						$overflow = 0;
							$type[$i] = preg_replace("/[^A-Za-z]/", "", $coltype[$i]);
							$len[$i] = $string = preg_replace("/[^0-9]/", "", $coltype[$i]);
						for($k=0;$k<count($header);$k++){
							$datatype[$k] = "";
							$datalength[$k] = 0;
							for($j=0;$j<$row;$j++){
								$occupied = false;
								if(!empty($array[$nbcol[$k]][$j])){
									$datatype[$k] = datatype($array[$nbcol[$k]][$j], $datatype[$k], $datalength[$k]);
									$datalength[$k] = datalength($array[$nbcol[$k]][$j], $datatype[$k], $datalength[$k]);
								}
							}
							
				
							if($datatype[$k] == $type[$i]){
								similar_text($header[$k], $column[$i], $perc);
								if($matching < $perc){
									for($r=0;$r<count($header);$r++){
										if(isset($rightcol[$r]) && $rightcol[$r] == $k){
											$occupied = true;
										}
									}
									
									if($occupied == false){
										$rightcol[$i] = $k;
										$matching = $perc;
									}
						
								}
							}
						}
						
					}else{
						$rightcol[$i] = $i;
					}
				}
				for($i=0;$i<count($header);$i++){
					if(isset($rightcol[$i])){
						$header[$rightcol[$i]] = $column[$i];
					}else{
						$overflow++;
						$rightcol[$i] = count($column)-1 + $overflow;
						for($k=count($column);$k<count($header);$k++){
							$datatype[$k] = "";
							$datalength[$k] = 0;
							for($l=0;$l<$row;$l++){
								if(!empty($array[$nbcol[$i]][$l])){
									$datatype[$k] = datatype($array[$nbcol[$i]][$l], $datatype[$k], $datalength[$k]);
									$datalength[$k] = datalength($array[$nbcol[$i]][$l], $datatype[$k], $datalength[$k]);
								}
							}
							mysqli_query($mysqli, "ALTER TABLE step2 ADD ".$header[$k]." ".$datatype[$k]." (".$datalength[$k].");");
						}
						$column[$i] = $header[$rightcol[$i]];
					}
					
				}
				
				$infotable = mysqli_query($_SESSION["mysqli"], 'SELECT 
										TABLE_CATALOG,
										TABLE_SCHEMA,
										TABLE_NAME, 
										COLUMN_NAME, 
										DATA_TYPE, 
										COLUMN_TYPE, 
										CHARACTER_MAXIMUM_LENGTH
										FROM INFORMATION_SCHEMA.COLUMNS
										where TABLE_NAME = "step2";');
										$i = 0;
										$coltype = Array();
										$charlength = Array();
				while($infos = $infotable->fetch_assoc()){
					$coltype[$i] = $infos["COLUMN_TYPE"];
					$charlength[$column[$i]] = $infos["CHARACTER_MAXIMUM_LENGTH"];
					$i++;					
				}
			}else if(count($header) <= count($column)){
				
				$rightcol = Array();
				for($i=0;$i<count($header);$i++){
					if($header[$i] != $column[$i]){
						$matching = 0;
						for($k=0;$k<count($column);$k++){
							$type[$k] = preg_replace("/[^A-Za-z]/", "", $coltype[$k]);
							$len[$k] = $string = preg_replace("/[^0-9]/", "", $coltype[$k]);
							$datatype[$i] = "";
							$datalength[$i] = 0;
							for($j=0;$j<$row;$j++){
									$occupied = false;
								
								if(!empty($array[$nbcol[$i]][$j])){
									$datatype[$i] = datatype($array[$nbcol[$i]][$j], $datatype[$i], $datalength[$i]);
									$datalength[$i] = datalength($array[$nbcol[$i]][$j], $datatype[$i], $datalength[$i]);
								}
							}
							if($datatype[$i] == $type[$k]){
								similar_text($header[$i], $column[$k], $perc);
								if($matching < $perc){
									for($r=0;$r<count($header);$r++){
										if(isset($rightcol[$r]) && $rightcol[$r] == $k){
							
											$occupied = true;
										}
										
									}
									
									if($occupied == false){
										$rightcol[$i] = $k;
										
										$matching = $perc;
									}
						
								}
							}
							
							
						}
						if(isset($rightcol[$i])){
							$header[$i] = $column[$rightcol[$i]];
						}
					}
				}				
			}
			
			for($j=0;$j<$row;$j++){
				$querydata[$j] = "INSERT INTO step2 (";
				for($i=0;$i<count($header);$i++){
					if($header[$i] != ""){
						$querydata[$j] .= $header[$i].", ";
					}else{
						$querydata[$j] .= "colonne".$i.", ";						
					}
				}
				$querydata[$j][strlen($querydata[$j])-2] = " ";
				$querydata[$j][strlen($querydata[$j])-1] = " ";
				$querydata[$j] = rtrim($querydata[$j]);
				$querydata[$j] .= ") VALUES (";
				for($i=0;$i<count($header);$i++){
					$type[$i] = preg_replace("/[^A-Za-z]/", "", $coltype[$rightcol[$i]]);
					$len[$i] = $string = preg_replace("/[^0-9]/", "", $coltype[$rightcol[$i]]);
					$datatype[$i] = datatype($array[$nbcol[$i]][$j], $type[$i], $len[$i]);
					$datalength[$i] = datalength($array[$nbcol[$i]][$j], $type[$i], $len[$i]);
					if($datatype[$i] == "date"){
						$array[$nbcol[$i]][$j] = date_format(date_create_from_format($datalength[$i], $array[$nbcol[$i]][$j]), "Y-m-d");
					}
					if(!empty($charlength[$header[$i]]) && $datalength[$i] > $charlength[$header[$i]]){
						mysqli_query($mysqli, "ALTER TABLE step2 MODIFY ".$header[$i]." ".$datatype[$i]." (".$datalength[$i].");");
					}
				}
				for($i=0;$i<count($header);$i++){
					if($datatype[$i] == "boolean"){
						$array[$nbcol[$i]][$j] = str_replace("oui", "1", $array[$nbcol[$i]][$j]);	
						$array[$nbcol[$i]][$j] = str_replace("non", "0", $array[$nbcol[$i]][$j]);	
						if(empty($array[$nbcol[$i]][$j])){
							$array[$nbcol[$i]][$j] = "0";
						}
					}
					if($datatype[$i] == "date"){
						if(!empty($array[$nbcol[$i]][$j])){
							$querydata[$j] .= "'".$array[$nbcol[$i]][$j]."', ";	
						}
					}else{
						if(!empty($array[$nbcol[$i]][$j])){
							$querydata[$j] .= "'".$array[$nbcol[$i]][$j]."', ";	
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
				
				$identifier = $header[0];
				$idvalue = $array[$nbcol[0]][$j];
				$simi = similar_text($header[0], $header[0]);
				for($i=0;$i<count($header);$i++){
					if(similar_text($header[$i], $header[0] > $simi)){
						$simi = similar_text($header[$i], $header[0]);
						$identifier = $header[$i];
						$idvalue = $array[$nbcol[$i]][$j];
					}
				}
				echo $querydata[$j];
				mysqli_query($mysqli, $querydata[$j]);
			}
        }
    }
?>