<?php
    class BDDsheet{
        public $header = Array();
        public $cells = Array();
        public $identifier = Array();
        public $row = Array();
        public $column = Array();
        public $bddtable;
        public $pdo;

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
			// echo'<pre>';
			// print_r($this->header);
			// echo'</pre>';
			// echo'<pre>';
			// print_r($this->cells);
			// echo'</pre>';
			// echo'<pre>';
			// print_r($this->identifier);
			// echo'</pre>';
			// echo'<pre>';
			// print_r($this->row);
			// echo'</pre>';
			// echo'<pre>';
			// print_r($this->column);
			// echo'</pre>';
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
                // echo'<pre>';
                // print_r($this->cells[$i]);
                // echo'</pre>';
                if(!isset($idcol)){
                    $data = Array();
                    $uniquedata = Array();
                    if(isset($this->cells[$i])){
                        for($j=0;$j<count($this->cells[$i]);$j++){
                            if(!in_array($this->cells[$i][$j]->getValue(), $data)){
                                $uniquedata[$j] = $this->cells[$i][$j]->getValue();
                            }
                            $data[$j] = $this->cells[$i][$j]->getValue();
                            // echo'<pre>unique';
                            // print_r($uniquedata);
                            // print_r($data);
                            // echo'data</pre>';
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
            // echo'idcol'.$idcol;
            if(isset($this->cells[$idcol])){
                for($j=0;$j<count($this->cells[$idcol]);$j++){
                    $this->identifier[$j] = new Identifier($this->cells[$idcol][$j], $j);
                }
                for($i=0;$i<count($this->header);$i++){
                    for($j=0;$j<count($this->identifier);$j++){
                        // echo $this->identifier[$j]->getValue()->getValue();
                        $this->cells[$i][$j]->setRowid($this->identifier[$j]->getValue()->getValue());
                    }
                }
            }
            // print_r($this->cells[$idcol]);
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

		//methods
        public function createTable($pdo){
			//$req = $pdo->prepare("CREATE TABLE IF NOT EXISTS `step1` (`numero_du_patient` int(11) DEFAULT NULL, `prenom` varchar(6) DEFAULT NULL, `nom` varchar(13) DEFAULT NULL, `sexe` enum('M','F','N/P') DEFAULT NULL, `date_de_naissance` date DEFAULT NULL, `groupe_sanguin` varchar(2) DEFAULT NULL, `pourcent_mutation` int(11) DEFAULT NULL, `mutation` tinyint(1) DEFAULT NULL, `deces` tinyint(1) DEFAULT NULL, `date_de_deces` date DEFAULT NULL)");
            //$req->execute();
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
        public function compareTablength($table1){
            if(count($this->getHeader()) > count($table1->getHeader())){
                for($i=count($table1->getHeader());$i<count($this->getHeader());$i++){
                    echo "ALTER TABLE ".$table1->getBdTab()." ADD ".$this->getCol()[$i]->getHead()." ".$this->getCol()[$i]->getType()." (".$this->getCol()[$i]->getLen().");";
                    $query = "ALTER TABLE ".$table1->getBdTab()." ADD ".$this->getCol()[$i]->getHead()." ".$this->getCol()[$i]->getType()." (".$this->getCol()[$i]->getLen().");";
                    $pdo->exec($query);
                }
            }
            for($i=0;$i<count($this->getHeader());$i++){
                if(!empty($this->getCol()[$i]->getLen()) && $this->getCol()[$i]->getLen() > $table1->getCol()[$i]->getLen()){
                    echo "ALTER TABLE ".$table1->getBdTab()." ADD ".$this->getCol()[$i]->getHead()." ".$this->getCol()[$i]->getType()." (".$this->getCol()[$i]->getLen().");";
                    $query = "ALTER TABLE ".$table1->getBdTab()." ADD ".$this->getCol()[$i]->getHead()." ".$this->getCol()[$i]->getType()." (".$this->getCol()[$i]->getLen().");";
                    $pdo->exec($query);
                }
            }
        }
        public function setNull($i){
            for($j=0;$j<count($this->getCol());$j++){
                echo $this->getCell()[$j][$i]->getValue();
                echo $this->getCol()[$j]->getType();
                echo $this->getCell()[$j][$i]->getColid()."<br>";
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
            echo $query;
            $this->pdo->exec($query);
        }
        public function dataLine($i, $table1){
            for($j=0;$j<count($this->getCol());$j++){
                $query = "UPDATE ".$table1->getBdTab()." SET ".$this->getCol()[$j]->getHead()."=".$this->getCell()[$j][$i]->getValue()." WHERE ".$this->getId()[$i]->getValue()->getColid()."=".$this->getCell()[$j][$i]->getRowid().";";
                echo $query;
                // print_r($this->pdo);
                $this->pdo->exec($query);
            }
        }
		public function sendTable($table1){
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
                echo $query;
                $this->pdo->exec($query);
            }
            if($this->identifier[$row]->getValue()->getColid() != $this->header[$column]->getValue()){
                if($this->cells[$column][$row]->getValue() != $value){
                    $this->cells[$column][$row]->setValue($value);
                    $query = "UPDATE ".$this->bddtable." SET ".$this->header[$column]->getValue()."='".$value."' WHERE ".$this->identifier[$row]->getValue()->getColid()."='".$this->identifier[$row]->getValue()->getValue()."';";
                    echo $query;
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
                        echo $query;
                        $this->pdo->exec($query);
                    }else{
                        $query = "INSERT INTO ".$this->bddtable." (".$this->header[$column]->getValue().") VALUES ('".$value."');";
                        echo $query;
                        $this->pdo->exec($query);
                    }
                    $this->cells[$column][$row]->setValue($value);
                }
            }
        }
    }
?>