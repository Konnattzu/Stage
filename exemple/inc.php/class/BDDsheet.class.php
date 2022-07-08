<?php
    class BDDsheet{
        public $header = Array();
        public $cells = Array();
        public $identifier = Array();
        public $row = Array();
        public $column = Array();
        public $bddtable;
        public $pdo;
        public $graph = Array();

        public function __construct($pdo, $bddtable){
            $this->bddtable = $bddtable;
            $this->pdo = $pdo;
            $infotable = $pdo->prepare('SHOW COLUMNS FROM '.$this->bddtable.';');
			$infotable->execute();
            $i=0;
			while($infos = $infotable->fetch(PDO::FETCH_ASSOC)){
				preg_match('/[a-z]+/', $infos['Type'], $type);
				preg_match('/\d+/', $infos['Type'], $len);
				if(!isset($type[0]) || $type[0] == ""){
					$type[0] = "varchar";
				}
				if(!isset($len[0]) || $len[0] == ""){
					$len[0] = 0;
				}
				$this->setHeader(new Header($infos["Field"], $i, ""), $i);
				$this->setCol(new Column($i, $this->getHeader()[$i]->getValue(), Array(), $pdo), $i);
				$this->column[$i]->setType($type[0]);
				$this->column[$i]->setLen($len[0]);
				$i++;
			}
			$query = $pdo->prepare('SELECT * FROM '.$this->bddtable.';');
			$query->execute();
			$row=0;
			while($data = $query->fetch(PDO::FETCH_ASSOC)){
				for($i=0;$i<count($this->header);$i++){
					$this->cells[$i][$row] = new Cell($data[$this->header[$i]->getValue()], $row, $i, $this->header[$i]->getValue(), $data[$this->header[0]->getValue()], $pdo);
				}
				$row++;
			}
            $this->initId();
            $this->initRow();
            $this->initCol();
            $this->initGraph();
        }

		//header
        public function initHeader($file){
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

		//cells
        public function initData($file, $header){
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
            $tempcells = array();
            for($j=0;$j<count($this->identifier);$j++){
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
            $tempcells = array();
            for($j=0;$j<count($this->header);$j++){
                for($i=0;$i<count($this->identifier);$i++){
                    $tempcells[$i] = $this->cells[$j][$i];
                }
                $this->column[$j] = new Column($j, $this->header[$j]->getValue(), $tempcells, $this->pdo);
                // echo'<pre>';
                // print_r($this->column[$j]);
                // echo'</pre>';
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
        
        //graphs
        public function initGraph(){
			$graph = new Graph();
			$graph->json_encode_private();
        }
        public function setGraph($graph){
            $this->graph = $graph;
        }
        public function getGraph(){
            return $this->graph;
        }

		//methods
        public function createTable(){
            $query = "CREATE TABLE IF NOT EXISTS ".$this->bddtable." (";
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
            // echo'<pre>';
            // print_r($publicObj[$name]);
            // echo'</pre>';
    
            return $publicObj;
        }
        public function compareTablength($table1){
            if(count($this->getHeader()) > count($table1->getHeader())){
                for($i=count($table1->getHeader());$i<count($this->getHeader());$i++){
                    $query = "ALTER TABLE ".$table1->getBdTab()." ADD ".$this->getCol()[$i]->getHead()." ".$this->getCol()[$i]->getType()." (".$this->getCol()[$i]->getLen().");";
                    $pdo->exec($query);
                }
                for($i=0;$i<count($this->getHeader());$i++){
                    if(!empty($this->getCol()[$i]->getLen()) && $this->getCol()[$i]->getLen() > $table1->getCol()[$i]->getLen()){
                        $query = "ALTER TABLE ".$table1->getBdTab()." ADD ".$this->getCol()[$i]->getHead()." ".$this->getCol()[$i]->getType()." (".$this->getCol()[$i]->getLen().");";
                        $this->pdo->exec($query);
                    }
                }
            }
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
        public function newLine($i, $table1){
            $query = 'INSERT INTO '.$table1->getBdTab().' ('.$this->getId()[$i]->getValue()->getColid().') VALUES ('.$this->getId()[$i]->getValue()->getRowid().');';
            $this->pdo->exec($query);
        }
        public function dataLine($i, $table1){
            if($this->getId()[$i]->getValue()->getRowid() != ""){
				for($j=0;$j<count($this->getCol());$j++){
					if($this->getCol()[$j]->getType() == "varchar" && strlen($this->getCell()[$j][$i]->getValue()) > $this->getCol()[$j]->getLen()){
						$query = 'ALTER TABLE '.$table1->getBdTab().' MODIFY '.$this->header[$j]->getValue().' '.$this->column[$j]->getType().' ('.strlen($this->getCell()[$j][$i]->getValue()).');';
						$this->pdo->exec($query);
						$this->getCol()[$j]->setLen(strlen($this->getCell()[$j][$i]->getValue()));
					}
					if($this->getCol()[$j]->getType() == "date"){
						if($this->getCol()[$j]->getCells()[$i]->getLen() == ""){
							$value = "NULL";
						}else{
                            echo $this->getCol()[$j]->getCells()[$i]->getLen();
                            echo trim($this->getCol()[$j]->getCells()[$i]->getValue(), "'");
							$date = date_create_from_format($this->getCol()[$j]->getCells()[$i]->getLen(), trim($this->getCol()[$j]->getCells()[$i]->getValue(), "'"));
                            print_r($date);
							$value = "'".date_format($date, "Y-m-d")."'";
						}
						$query = "UPDATE ".$table1->getBdTab()." SET ".$this->getCol()[$j]->getHead()."=".$value." WHERE ".$this->getId()[$i]->getValue()->getColid()."=".$this->getCell()[$j][$i]->getRowid().";";
					}else{
						$query = "UPDATE ".$table1->getBdTab()." SET ".$this->getCol()[$j]->getHead()."=".$this->getCell()[$j][$i]->getValue()." WHERE ".$this->getId()[$i]->getValue()->getColid()."=".$this->getCell()[$j][$i]->getRowid().";";
					}
					// print_r($this->pdo);
					$this->pdo->exec($query);
				}
			}
        }
		public function sendTable($table1){
            $this->createTable();
            //pour chaque ligne
            for($i=0;$i<count($this->getId());$i++){
                //si la ligne possède un ID
                if(null !== $this->getId()[$i]->getValue()->getValue()){
                    $this->setNull($i);
                    $exists = false;
                    for($j=0;$j<count($table1->getId());$j++){
                        if($this->getId()[$i]->getValue()->getValue() == $table1->getId()[$j]->getValue()->getValue()){
                            $exists = true;
                        }
                    }
                    if($exists == true){
                        $this->dataLine($i, $table1);
                    }else{
                        $this->newLine($i, $table1);
                        $this->dataLine($i, $table1);
                    }
                }
            }
        }
        public function sendData($column, $row, $value){
            // print_r($this->identifier);
            if(!empty($this->column[$column]->getLen()) && strlen($value) > $this->column[$column]->getLen()){
                $query = "ALTER TABLE ".$this->bddtable." MODIFY ".$this->header[$column]->getValue()." ".$this->column[$column]->getType()." (".$this->column[$column]->getLen().");";
                $this->pdo->exec($query);
            }
            if($this->identifier[$row]->getValue()->getColid() != $this->header[$column]->getValue()){
                if($this->cells[$column][$row]->getValue() != $value){
                    $this->cells[$column][$row]->setValue($value);
                    $query = "UPDATE ".$this->bddtable." SET ".$this->header[$column]->getValue()."='".$value."' WHERE ".$this->identifier[$row]->getValue()->getColid()."='".$this->identifier[$row]->getValue()->getValue()."';";
                    $this->pdo->exec($query);
                }
            }else if($this->identifier[$row]->getValue()->getColid() == $this->header[$column]->getValue()){
                $exists = false;
                for($i=0;$i<count($this->getId());$i++){
                    if(null !== $this->identifier[$row]->getValue()->getValue()){
                        if($this->getId()[$i]->getValue()->getValue() == $value){
                            $exists = true;
                        }
                    }
                }
                if($exists == false){
                    if($this->cells[$column][$row]->getValue() != ""){
                        $query = "UPDATE ".$this->bddtable." SET ".$this->header[$column]->getValue()."='".$value."' WHERE ".$this->identifier[$row]->getValue()->getColid()."='".$this->identifier[$row]->getValue()->getValue()."';";
                        $this->pdo->exec($query);
                    }else{
                        $query = "INSERT INTO ".$this->bddtable." (".$this->header[$column]->getValue().") VALUES ('".$value."');";
                        $this->pdo->exec($query);
                    }
                    $this->cells[$column][$row]->setValue($value);
                }
            }
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
        public function export_data_to_csv(){
            $r = $this->pdo->prepare('SELECT annee_de_naissance, homologie___germline FROM '.$this->bddtable.';');
            $r->execute();
            $tab = Array();
            $i = 0;
            while($data = $r->fetch(PDO::FETCH_ASSOC)){
                $tab[$i] = $data;
                $i++;
            }
            
            $fichier_csv = fopen("documents/graphfile.csv", "w+");
        
            fprintf($fichier_csv, chr(0xEF).chr(0xBB).chr(0xBF));
        
            foreach($tab as $ligne){
                fputcsv($fichier_csv, $ligne, ",");
            }
        
            fclose($fichier_csv);
        }
    }
?>