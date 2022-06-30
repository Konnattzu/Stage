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
            $idcol = "";
            for($i=0;$i<count($this->header);$i++){
                if(!isset($idcol) || $idcol == ""){
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
            if(!isset($idcol) || $idcol == ""){
                $idcol = 0;
            }
            if(isset($this->cells[$idcol])){
                for($j=0;$j<count($this->cells[$idcol]);$j++){
                    $this->identifier[$j] = new Identifier($this->cells[$idcol][$j], $j);
                }
            }
            for($i=0;$i<count($this->header);$i++){
                for($j=0;$j<count($this->identifier);$j++){
                    echo $this->identifier[$j]->getValue()->getValue();
                    $this->cells[$i][$j]->setRowid($this->identifier[$j]->getValue()->getValue());
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
		public function sendTable(){
			
		}
    }
?>