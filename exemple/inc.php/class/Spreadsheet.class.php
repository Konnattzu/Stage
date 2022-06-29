<?php
    class Spreadsheet implements \JsonSerializable{
        public $header = Array();
        public $headgroups = Array();
        public $cells = Array();
        public $identifier = Array();
        public $row = Array();
        public $column = Array();
        public $bddtable = "step2";
        public $bddbase = "step1";
        public $file = Array();

        public function __construct($file, $pdo){
			$this->file = $file;
            $this->initHeader();
            $this->initData($this->header, $pdo);
            $this->initId($this->cells);
            $this->initRow($this->identifier, $this->header, $this->cells);
            $this->initCol($this->header, $this->identifier, $this->cells, $pdo);
			// echo'<pre>';
			// print_r($this->header);
			// print_r($this->cells);
			// print_r($this->identifier);
			// print_r($this->row);	
			// print_r($this->column);
			// echo'</pre>';
        }

		//header
        public function initHeader(){
			$file = $this->file;
			$nbdata = 0;
            for($i=0;$i<count($file);$i++){
				for($j=0;$j<count($file[$i]);$j++){
					if($file[$i][$j] != ""){
						$nbdata++;
					}
				}
				if($nbdata > ($j/2)){
					$filehead = $file[$i];
					$this->file = array_slice($this->file, $i);
					$i = count($file);
				}else{
					for($j=0;$j<count($file[$i]);$j++){
						if($file[$i][$j] != ""){
							$this->headgroups[$j] = $file[$i][$j];
						}else{
							$this->headgroups[$j] = "";
						}
					}
				}
			}
            for($j=0;$j<count($filehead);$j++){
				if($filehead[$j] == ""){
					$this->header[$j] = new Header("colonne".$j, $j, $this->headgroups[$j]);
				}else{
					$this->header[$j] = new Header($filehead[$j], $j, $this->headgroups[$j]);
				}
            }
        }
        public function setHeader($header, $pos){
            $this->header[$pos] = $header;
        }
        public function getHeader(){
            return $this->header;
        }

		//cells
        public function initData($header, $pdo){
			$file = $this->file;
            $row=0;
			$rowid = Array();
            for($j=0;$j<count($header);$j++){
                $this->cells[$j] = Array();
            }
			$colnb = 0;
			foreach ($file as $col) {
				if($colnb > 0){
					$rowid[$row] = $col[0];
					$row++;
				}
				$colnb++;
			}
			$row=0;
			$colnb = 0;
            foreach ($file as $col) {
				if($colnb > 0){
					for($j=0;$j<count($header);$j++){
						$this->cells[$j][$row] = new Cell($col[$j], $row, $j, $header[$j]->getValue(), $rowid[$row], $pdo);
					}
					$row++;
				}
				$colnb++;
            }
        }
        public function setCell(){
            $this->header = $header;
        }
        public function getCell(){
            return $this->cells;
        }

		//identifier
        public function initId($cells){
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

		//row
        public function initRow($identifier, $header, $cells){
            for($j=0;$j<count($cells[0]);$j++){
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

		//column
        public function initCol($header, $identifier, $cells, $pdo){
            for($j=0;$j<count($header);$j++){
                for($i=0;$i<count($identifier);$i++){
                    $tempcells[$i] = $cells[$j][$i];
                }
                $this->column[$j] = new Column($j, $header[$j], $tempcells, $pdo);
            }
        }
        public function setCol($col, $pos){
            $this->column[$pos] = $col;
        }
        public function getCol(){
            return $this->column;
        }

		//bddtable
        public function setBdTab($bddtable){
            $this->bddtable = $bddtable;
        }
        public function getBdTab(){
            return $this->bddtable;
        }

		//bddbase
        public function setBdB($bddbase){
            $this->bddbase = $bddbase;
        }
        public function getBdB(){
            return $this->bddbase;
        }

		//methods
        public function createTable($pdo){
            $query = 'CREATE TABLE IF NOT EXISTS '.$this->bddtable.' LIKE '.$this->bddbase.';';
            $pdo->exec($query);
        }
        public function createBase($pdo){
			$querytable = "CREATE TABLE IF NOT EXISTS step1
			 (";
			for($i=0;$i<count($this->header);$i++){
				$datalength = 0;
				$datatype = "";
				$this->header[$i]->setValue(clear($this->header[$i]->getValue()));
				if($this->header[$i]->getValue() == ""){
					$querytable .= 'colonne'.$i.' ';
				}else{
					if(strlen($this->header[$i]->getValue()) > 64){
						$this->header[$i]->setValue(substr($this->header[$i]->getValue(), 0, 64));
					}
					$querytable .= $this->header[$i]->getValue().' ';
				}
				$enum = Array();
				for($j=0;$j<count($this->row);$j++){
					if($this->cells[$i][$j]->getValue() != ""){
						$enum[count($enum)] = $this->cells[$i][$j]->getValue();
						if(count($enum)>0){
							for($k=0;$k<count($enum)-1;$k++){
								if(trim($enum[$k]) == trim($this->cells[$i][$j]->getValue())){
									unset($enum[count($enum)-1]);
								}
							}
						}
					}
					$datalength = datalength($this->cells[$i][$j]->getValue(), $datatype, $datalength);
					$datatype = datatype($this->cells[$i][$j]->getValue(), $datatype, $datalength);
					if(($datatype == "boolean") && ($this->cells[$i][$j]->getValue() != "oui") && ($this->cells[$i][$j]->getValue() != "non") && ($this->cells[$i][$j]->getValue() != "1") && ($this->cells[$i][$j]->getValue() != "0")){
						$this->cells[$i][$j]->getCom()->setValue(preg_replace("/(oui|non|1|0)/", " ", $this->cells[$i][$j]->getValue()));
						$this->cells[$i][$j]->getCom()->setValue($this->cells[$i][$j]->getCom()->getValue());
						$this->cells[$i][$j]->setValue(str_replace($this->cells[$i][$j]->getCom()->getValue(), " ", $this->cells[$i][$j]->getValue()));
						$this->cells[$i][$j]->setValue(trim($this->cells[$i][$j]->getValue()));
					}
					if($datatype == ""){
						$datatype = "varchar";
					}
				}
				if(count($this->column[$i]->getCells())>16){
					if(count($enum)<8 && $datatype != "boolean" && count($enum)>0){
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
            $query = $querytable;
            $pdo->exec($query);
        }
		public function jsonSerialize(){
			$vars = get_object_vars($this);
			return $vars;
		}
		function json_encode_private() {
			function stackVal($value, $name) {
				if(is_array($value)) {
					$public[$name] = [];
	
					foreach ($value as $item) {
						if (is_object($item)) {
							$itemArray = extract_props($item);
							$public[$name][] = $itemArray;
						} else {
							$itemArray = stackVal($item, $name);
				 			$public[$name][] = $itemArray;
						}
					}
				} else if(is_object($value)) {
					$public[$name] = extract_props($value);
				} else $public[$name] = $value;
				return $public[$name];
			}
			function extract_props($object) {
				$publicObj = [];
		
				$reflection = new ReflectionClass(get_class($object));
		
				
				
				foreach ($reflection->getProperties() as $property) {
					$property->setAccessible(true);
		
					$value = $property->getValue($object);
					$name = $property->getName();
					$publicObj[$name] = stackVal($value, $name);
				}
				// echo'<pre>';
				// print_r($publicObj[$name]);
				// echo'</pre>';
		
				return $publicObj;
			}
			echo'<script>
			spreadsheet = new Spreadsheet();
			spreadsheet.dataFill('.json_encode(extract_props($this)).');
			</script>';
		}
        public function addData($file, $pdo){
            //récupérer header table 1
			$basetable = new BDDsheet($pdo);
            $infotable = $pdo->prepare('SHOW COLUMNS FROM '.$this->bddbase.';');
			$infotable->execute();
            $i=0;
			while($infos = $infotable->fetch(PDO::FETCH_ASSOC)){
				preg_match('/[a-z]+/', $infos['Type'], $type);
				preg_match('/\d+/', $infos['Type'], $len);
				if(!isset($type[0]) || $type[0] == ""){
					$type[0] = "";
				}
				if(!isset($len[0]) || $len[0] == ""){
					$len[0] = "";
				}
				$basetable->setHeader(new Header($infos["Field"], $i, ""), $i);
				$basetable->setCol(new Column($i, $basetable->getHeader()[$i]->getValue(), Array(), $pdo), $i);
				$basetable->column[$i]->setType($type[0]);
				$basetable->column[$i]->setLen($len[0]);
				$i++;
			}
			
            //si table 2 plus grande que table 1
			if(count($this->header) >= count($basetable->header)){
				$righthead = Array();
				//Pour chaque colonne de 1
				for($i=0;$i<count($basetable->header);$i++){
					// if($this->header[$i] != $basetable->header[$i]){
					// 	$matching = 0;
					// 	$overflow = 0;
					// 	$coltype = preg_replace("/[^A-Za-z]/", "", $basetable->column[$i]->getType());
					// 	$collen = $string = preg_replace("/[^0-9]/", "", $basetable->column[$i]->getType());
					// 	for($k=0;$k<count($basetable->header);$k++){
					// 		$headtype = "";
					// 		$headlen = 0;
					// 		for($j=0;$j<count($this->row);$j++){
					// 			$occupied = false;
					// 			if(!empty($this->cells[$k][$j]->value)){
					// 				$headtype = datatype($this->cells[$k][$j]->value, $headtype, $headlen);
					// 				$headlen = datalength($this->cells[$k][$j]->value, $headtype, $headlen);
                    //                 $this->cells[$k][$j]->setType($headtype);
                    //                 $this->cells[$k][$j]->setLen($headlen);
					// 			}
					// 		}
                    //         $this->column[$k]->setType($this->cells[$k][count($this->cells[$k])-1]->getType());
                    //         $this->column[$k]->setLen($this->cells[$k][count($this->cells[$k])-1]->getLen());
					// 		echo'<pre>';
					// 			print_r($this->column[$k]->getHead());
					// 			print_r($basetable->column[$k]->getHead());
					// 		echo'</pre>';
					// 		if($this->column[$k]->getType() == $basetable->column[$i]->getType()){
					// 			similar_text($this->header[$k]->getValue(), $basetable->header[$k]->getValue(), $perc);
					// 			if($matching < $perc){
					// 				for($r=0;$r<count($this->header);$r++){
					// 					if(isset($righthead[$r]) && $righthead[$r] == $this->header){
					// 						$occupied = true;
					// 					}
					// 				}
					// 				if($occupied == false){
					// 					$righthead[$i] = $basetable->header[$k];
					// 					$matching = $perc;
					// 				}
					// 			}
					// 		}
					// 	}
					// }else{
						$righthead[$i] = $basetable->header[$i];
						$overflow = 0;
					// }
				}
				for($i=0;$i<count($this->header);$i++){
					if(isset($righthead[$i])){
						$this->header[$i] = $righthead[$i];
					}else{
						$overflow++;
						print_r($this->header[count($basetable->column)-1 + $overflow]);
						$righthead[$i] = $this->header[count($basetable->column)-1 + $overflow];
					}
				}
				for($k=count($basetable->column);$k<count($this->header);$k++){
					$basetable->column[$k] = $righthead[$k];
					$header[$k] = $righthead[$k];
					$headtype = "";
					$headlen = 0;
					for($l=0;$l<count($this->row);$l++){
						if(!empty($this->cells[$k][$l]->getValue())){
							$headtype = datatype($this->cells[$k][$l]->getValue(), $headtype, $headlen);
							$headlen = datalength($this->cells[$k][$l]->getValue(), $headtype, $headlen);
							$this->cells[$k][$l]->setType($headtype);
							$this->cells[$k][$l]->setLen($datalength);
						}else{
							$this->cells[$k][$l]->setType("varchar");
							$this->cells[$k][$l]->setLen(16);
						}
					}
					$this->column[$k]->setType($basetable->column[$k]->getType());
					$this->column[$k]->setLen($basetable->column[$k]->getLen());
					echo strlen($this->header[$k]->getValue());
					if(strlen($this->header[$k]->getValue()) > 64){
						$this->header[$k]->setValue(substr($this->header[$k]->getValue(), 0, 64));
					}
					echo 'ALTER TABLE step2 ADD '.$this->header[$k]->getValue().' '.$this->column[$k]->getType().'('.$this->column[$k]->getLen().');';
					$req = $pdo->prepare('ALTER TABLE step2 ADD '.$this->header[$k]->getValue().' '.$this->column[$k]->getType().'('.$this->column[$k]->getLen().');');
					$req->execute();
				}

            //si table 1 plus grande que table 2
			}else if(count($this->header) <= count($column)){
				$righthead = Array();
				for($i=0;$i<count($this->header);$i++){
					if($this->header[$i] != $basetable->header[$i]){
						$matching = 0;
						$coltype = preg_replace("/[^A-Za-z]/", "", $basetable->column[$i]->getType());
						$collen = $string = preg_replace("/[^0-9]/", "", $basetable->column[$i]->getType());
						for($k=0;$k<count($this->header);$k++){
							$headtype = "";
							$headlen = 0;
							for($j=0;$j<count($this->row);$j++){
								$occupied = false;
								if(!empty($this->cells[$k][$j]->value)){
									$headtype = datatype($this->cells[$k][$j]->getValue(), $headtype, $headlen);
									$headlen = datalength($this->cells[$k][$j]->getValue(), $headtype, $headlen);
                                    $this->cells[$k][$j]->setType($headtype);
                                    $this->cells[$k][$j]->setLen($headlen);
								}
							}
                            $this->column[$k]->setType($basetable->column[$k]->getType());
                            $this->column[$k]->setLen($this->cells[$k][count($this->cells[$k])-1]->getLen());
							if($this->column[$k]->getType() == $basetable->column[$k]->getType()){
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
			}
			for($j=0;$j<count($this->row);$j++){
				$querydata[$j] = "INSERT INTO step2 (";
				for($i=0;$i<count($this->column)-1;$i++){
					if(strlen($this->header[$i]->getValue() > 64)){
						$this->header[$i]->setValue(substr($this->header[$i]->getValue(), 0, 64));
					}
					if($this->header[$i]->getValue() != ""){
						$querydata[$j] .= $this->header[$i]->getValue().", ";
					}else{
						$querydata[$j] .= "colonne".$i.", ";						
					}
				}
				if(strlen($this->header[$i]->getValue() > 64)){
					$this->header[$i]->setValue(substr($this->header[$i]->getValue(), 0, 64));
				}
				if($this->header[$i]->getValue() != ""){
					$querydata[$j] .= $this->header[$i]->getValue();
				}else{
					$querydata[$j] .= "colonne".$i;						
				}
				$querydata[$j] .= ") VALUES (";
				for($i=0;$i<count($this->header);$i++){
					$this->column[$i]->setType($basetable->column[$i]->getType());
					$this->cells[$i][$j]->setType($this->column[$i]->getType());
					if($this->cells[$i][$j]->getType() == "date"){
						$this->cells[$i][$j]->setLen(datalength($this->cells[$i][$j]->getValue(), $this->cells[$i][$j]->getType(), $this->cells[$i][$j]->getLen()));
					}else{
						$this->cells[$i][$j]->setLen($this->column[$i]->getLen());
					}
					if($this->cells[$i][$j]->getType() == "date" && $this->cells[$i][$j]->getValue() != ""){
						$this->cells[$i][$j]->setValue(date_format(date_create_from_format($this->cells[$i][$j]->getLen(), $this->cells[$i][$j]->getValue()), "Y-m-d"));
					}
					if(!empty($this->column[$i]->getLen()) && $this->column[$i]->getLen() > $basetable->column[$i]->getLen()){
                        $req = $pdo->prepare('ALTER TABLE step2 MODIFY '.$this->header[$i]->getValue().' '.$this->column[$i]->getType().' ('.$this->column[$i]->getLen().');');
                        $req->execute();
					}
				}
				for($i=0;$i<count($this->header)-1;$i++){
					if($this->column[$i]->getType() == "tinyint"){
						$this->cells[$i][$j]->setValue(str_replace("oui", "1", $this->cells[$i][$j]->getValue()));	
						$this->cells[$i][$j]->setValue(str_replace("non", "0", $this->cells[$i][$j]->getValue()));	
						if(empty($this->cells[$i][$j]->getValue())){
							$this->cells[$i][$j]->setValue("0");
						}
					}
					if($this->column[$i]->getType() == "date"){
						if(!empty($this->cells[$i][$j]->getValue())){
							$querydata[$j] .= "'".$this->cells[$i][$j]->getValue()."', ";	
						}else{
							$querydata[$j] .= "NULL, ";
						}
					}else if($this->column[$i]->getType() == "int"){
						if(datatype($this->cells[$i][$j]->getValue(), $this->cells[$i][$j]->getType()) == "varchar"){
							$this->cells[$i][$j]->getCom()->setValue(preg_replace("/[^A-Za-z]/", "", $this->cells[$i][$j]->getValue()));
							$this->cells[$i][$j]->setValue(str_replace($this->cells[$i][$j]->getCom()->getValue(), "", $this->cells[$i][$j]->getValue()));
						}
						if(!empty($this->cells[$i][$j]->getValue())){
							$querydata[$j] .= "'".$this->cells[$i][$j]->getValue()."', ";	
						}else{
							$querydata[$j] .= "NULL, ";
						}
					}else{
						if(!empty($this->cells[$i][$j]->getValue())){
							$querydata[$j] .= "'".$this->cells[$i][$j]->getValue()."', ";	
						}else{
							$querydata[$j] .= "NULL, ";
						}
					}
				}
				if($this->column[$i]->getType() == "date"){
					if(!empty($this->cells[$i][$j]->getValue())){
						$querydata[$j] .= "'".$this->cells[$i][$j]->getValue()."'";
					}else{
						$querydata[$j] .= "NULL";
					}
				}else{
					if(!empty($this->cells[$i][$j]->getValue())){
						$querydata[$j] .= "'".$this->cells[$i][$j]->getValue()."'";
					}else{
						$querydata[$j] .= "NULL";
					}
				}
				$querydata[$j] .= ");";
				
				$identifier = $this->identifier[$j];
				$idvalue = $this->cells[0][$j]->getValue();
				$simi = similar_text($this->header[0]->getValue(), $this->header[0]->getValue());
				for($i=0;$i<count($this->header);$i++){
					if(similar_text($this->header[$i]->getValue(), $this->header[0]->getValue() > $simi)){
						$simi = similar_text($this->header[$i], $this->header[0]);
						$identifier = $this->header[$i];
						$idvalue = $this->cells[0][$j]->getValue();
					}
				}
				// print_r($querydata[$j]);
                $req = $pdo->prepare($querydata[$j]);
                $req->execute();
			}
        }
    }
?>