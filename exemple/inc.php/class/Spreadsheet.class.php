<?php
    class Spreadsheet{
        public $header = Array();
        public $headgroups = Array();
        public $cells = Array();
        public $identifier = Array();
        public $row = Array();
        public $column = Array();
        public $bddtable = "step2";
        public $bddbase = "step1";
        public $file = Array();
        public $pdo;

        public function __construct($file, $pdo){
			$this->file = $file;
			$this->pdo = $pdo;
            $this->initHeader();
            $this->initData();
            $this->initId();
            $this->initRow();
            $this->initCol();
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
        public function initData(){
			$file = $this->file;
            $row=0;
			$rowid = Array();
            for($j=0;$j<count($this->header);$j++){
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
					for($j=0;$j<count($this->header);$j++){
						$this->cells[$j][$row] = new Cell($col[$j], $row, $j, $this->header[$j]->getValue(), $rowid[$row], $this->pdo);
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
        public function initId(){
            for($i=0;$i<count($this->header);$i++){
                if(!isset($idcol)){
                    $data = Array();
                    $uniquedata = Array();
                    if(isset($this->cells[$i])){
                        for($j=0;$j<count($this->cells[$i]);$j++){
                            if(!in_array($this->cells[$i][$j]->getValue(), $data)){
                                $uniquedata[$j] = $this->cells[$i][$j]->getValue();
                            }
                            $data[$j] = $this->cells[$i][$j]->getValue();
                        }
                        if(count($uniquedata) == count($data)){
                            $idcol = $i;
                        }
                    }
                }
            }
            if(!isset($idcol)){
                $idcol = 0;
            }
            if(isset($this->cells[$idcol])){
                for($j=0;$j<count($this->cells[$idcol]);$j++){
                    $this->identifier[$j] = new Identifier($this->cells[$idcol][$j], $j);
                }
                for($i=0;$i<count($this->header);$i++){
                    for($j=0;$j<count($this->identifier);$j++){
                        $this->cells[$i][$j]->setRowid($this->identifier[$j]->getValue()->getValue());
                    }
                }
            }
        }
        public function setId(){
            $this->header = $header;
        }
        public function getId(){
            return $this->identifier;
        }

		//row
        public function initRow(){
            for($j=0;$j<count($this->cells[0]);$j++){
                for($i=0;$i<count($this->header);$i++){
                    $tempcells[$i] = $this->cells[$i][$j];
                }
                $this->row[$j] = new Row($this->identifier[$j], $j, $tempcells);
            }
        }
        public function setRow(){
            $this->header = $header;
        }
        public function getRow(){
            return $this->row;
        }

		//column
        public function initCol(){
            for($j=0;$j<count($this->header);$j++){
                for($i=0;$i<count($this->identifier);$i++){
                    $tempcells[$i] = $this->cells[$j][$i];
                }
                $this->column[$j] = new Column($j, $this->header[$j], $tempcells, $this->pdo);
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
        public function createTable(){
            $query = 'CREATE TABLE IF NOT EXISTS '.$this->bddtable.' LIKE '.$this->bddbase.';';
            $this->pdo->exec($query);
        }
        public function createBase(){
			$query = "CREATE TABLE IF NOT EXISTS ".$this->bddbase." (";
            for($i=0;$i<count($this->header)-1;$i++){
                $query .= $this->header[$i]->getValue()." ".$this->column[$i]->getType();
				if($this->column[$i]->getType() == "date"){
					$query .= " DEFAULT NULL, ";
				}else{
					$query .= "(".$this->column[$i]->getLen().") DEFAULT NULL, ";
				}
            }
			$query .= $this->header[$i]->getValue()." ".$this->column[$i]->getType();
			if($this->column[$i]->getType() == "date"){
				$query .= " DEFAULT NULL";
			}else{
				$query .= "(".$this->column[$i]->getLen().") DEFAULT NULL";
			}
            $query .= ") ENGINE=MyISAM DEFAULT CHARSET=utf8;";
			$req = $this->pdo->prepare($query);
            $req->execute();
        }

		public function setNull($i){
            for($j=0;$j<count($this->getCol());$j++){
                if($this->getCell()[$j][$i]->getValue() == ""){
                    switch($this->getCol()[$j]->getType()){
                        case "int":
                            $this->getCell()[$j][$i]->setValue(0);
                        break;
                        case "tinyint":
                            $this->getCell()[$j][$i]->setValue(0);
                        break;
                        case "date":
                            $this->getCell()[$j][$i]->setValue("0001-01-01");
                        break;
                        case "varchar":
                            $this->getCell()[$j][$i]->setValue("NULL");
                        break;
                        case "enum":
                            $this->getCell()[$j][$i]->setValue("NULL");
                        break;
                    }
                }else{
                    switch($this->getCol()[$j]->getType()){
                        case "varchar":
                            $this->getCell()[$j][$i]->setValue("'".$this->getCell()[$j][$i]->getValue()."'");
                        break;
                        case "enum":
                            $this->getCell()[$j][$i]->setValue("'".$this->getCell()[$j][$i]->getValue()."'");
                        break;
                    }
                }
                switch($this->getCol()[$j]->getType()){
                    case "date":
                        $this->getCell()[$j][$i]->setValue("'".$this->getCell()[$j][$i]->getValue()."'");
                    break;
                    case "tinyint":
                        $this->getCell()[$j][$i]->setValue("'".$this->getCell()[$j][$i]->getValue()."'");
                    break;
                }
            }
        }
		public function newLine($i, $basetable){
			if($this->getId()[$i]->getValue()->getRowid() != ""){
				$query = 'INSERT INTO '.$this->getBdTab().' ('.$this->getId()[$i]->getValue()->getColid().') VALUES ('.$this->getId()[$i]->getValue()->getRowid().');';
				$this->pdo->exec($query);
			}            
        }
        public function dataLine($i, $basetable){
			if($this->getId()[$i]->getValue()->getRowid() != ""){
				for($j=0;$j<count($this->getCol());$j++){
					if($this->getCol()[$j]->getType() == "varchar" && strlen($this->getCell()[$j][$i]->getValue()) > $this->getCol()[$j]->getLen()){
						$query = 'ALTER TABLE '.$this->getBdTab().' MODIFY '.$this->header[$j]->getValue().' '.$this->column[$j]->getType().' ('.strlen($this->getCell()[$j][$i]->getValue()).');';
						$this->pdo->exec($query);
						$this->getCol()[$j]->setLen(strlen($this->getCell()[$j][$i]->getValue()));
					}
					if($this->getCol()[$j]->getType() == "date"){
						if($this->getCol()[$j]->getCells()[$i]->getLen() == ""){
							$value = "NULL";
						}else{
							$date = date_create_from_format($this->getCol()[$j]->getCells()[$i]->getLen(), trim($this->getCol()[$j]->getCells()[$i]->getValue(), "'"));
							$value = "'".date_format($date, "Y-m-d")."'";
						}
						$query = "UPDATE ".$this->getBdTab()." SET ".$this->getCol()[$j]->getHead()->getValue()."=".$value." WHERE ".$this->getId()[$i]->getValue()->getColid()."=".$this->getCell()[$j][$i]->getRowid().";";
					}else{
						$query = "UPDATE ".$this->getBdTab()." SET ".$this->getCol()[$j]->getHead()->getValue()."=".$this->getCell()[$j][$i]->getValue()." WHERE ".$this->getId()[$i]->getValue()->getColid()."=".$this->getCell()[$j][$i]->getRowid().";";
					}
					// print_r($this->pdo);
					$this->pdo->exec($query);
				}
			}
        }
		public function fillTable($basetable){
            $this->createTable();
            //pour chaque ligne
            for($i=0;$i<count($this->getId());$i++){
                //si la ligne possède un ID
                if(null !== $this->getId()[$i]->getValue()->getValue()){
                    $this->setNull($i);
                    $exists = false;
                        $this->newLine($i, $basetable);
                        $this->dataLine($i, $basetable);
                }
            }
        }

		function json_encode_private() {
			echo'<script>
			spreadsheet = new Spreadsheet();
			spreadsheet.dataFill('.json_encode($this->extract_props($this)).');
			</script>';
		}
        function stackVal($value, $name) {
            if(is_array($value)) {
                $public[$name] = [];

                foreach ($value as $item) {
                    if (is_object($item)) {
                        $itemArray = $this->extract_props($item);
                        $public[$name][] = $itemArray;
                    } else {
                        $itemArray = $this->stackVal($item, $name);
                         $public[$name][] = $itemArray;
                    }
                }
            } else if(is_object($value)) {
                $public[$name] = $this->extract_props($value);
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
                $publicObj[$name] = $this->stackVal($value, $name);
            }
    
            return $publicObj;
        }
		public function repartColumns($template){
			$righthead = Array();
			//Pour chaque colonne de 1
			for($i=0;$i<count($this->getHeader());$i++){
				if($this->getHeader()[$i] != $template->getHeader()[$i]){
					$matching = 0;
					$overflow = 0;
					for($k=0;$k<count($template->getHeader());$k++){
							$occupied = false;
						if($this->column[$i]->getType() == $template->column[$k]->getType()){
							similar_text($this->header[$i]->getValue(), $template->getHeader()[$k]->getValue(), $perc);
							if($matching < $perc){
								for($r=0;$r<count($this->header);$r++){
									if(isset($righthead[$r]) && $righthead[$r] == $this->header[$i]){
										$occupied = true;
									}
								}
								if($occupied == false){
									$righthead[$i] = $template->getHeader()[$k];
									$matching = $perc;
								}
							}
						}
					}
				}else{
					$righthead[$i] = $template->getHeader()[$i];
				}
			}
			for($i=0;$i<count($this->header);$i++){
				if(isset($righthead[$i])){
					$this->header[$i] = $righthead[$i];
				}else{
					$overflow++;
					// print_r($this->header[count($basetable->column)-1 + $overflow]);
					$righthead[$i] = $this->header[count($template->column)-1 + $overflow];
				}
			}
			for($k=count($template->column);$k<count($this->header);$k++){
				$template->column[$k] = $righthead[$k];
				$header[$k] = $righthead[$k];
				$headtype = "";
				$headlen = 0;
				for($l=0;$l<count($this->row);$l++){
					if(!empty($this->cells[$k][$l]->getValue())){
						$headtype = datatype($this->cells[$k][$l]->getValue(), $headtype, $headlen);
						$headlen = datalength($this->cells[$k][$l]->getValue(), $headtype, $headlen);
						$this->cells[$k][$l]->setLen($datalength);
					}else{
						$this->cells[$k][$l]->setType("varchar");
						$this->cells[$k][$l]->setLen(16);
					}
				}
				$this->column[$k]->setLen($basetable->column[$k]->getLen());
				// echo strlen($this->header[$k]->getValue());
				if(strlen($this->header[$k]->getValue()) > 64){
					$this->header[$k]->setValue(substr($this->header[$k]->getValue(), 0, 64));
				}
				$req = $pdo->prepare('ALTER TABLE step2 ADD '.$this->header[$k]->getValue().' '.$this->column[$k]->getType().'('.$this->column[$k]->getLen().');');
				$req->execute();
			}
		}
        public function addData($file){
			$this->createBase();
            //récupérer header table 1
			$basetable = new BDDsheet($this->pdo, $this->bddbase);
            $infotable = $this->pdo->prepare('SHOW COLUMNS FROM '.$this->bddbase.';');
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
				$basetable->setCol(new Column($i, $basetable->getHeader()[$i]->getValue(), Array(), $this->pdo), $i);
				$basetable->column[$i]->setType($type[0]);
				$basetable->column[$i]->setLen($len[0]);
				$i++;
			}
            //si table 2 plus grande que table 1
			if(count($this->getHeader()) >= count($basetable->getHeader())){
				$basetable->repartColumns($this);
            //si table 1 plus grande que table 2
			}else if(count($this->getHeader()) <= count($basetable->getHeader())){
				$this->repartColumns($basetable);
			}
			
			$this->fillTable($basetable);
        }
    }
?>