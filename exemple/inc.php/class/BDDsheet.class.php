<?php
    class BDDsheet{
        public $header = Array();
        public $cells = Array();
        public $identifier = Array();
        public $row = Array();
        public $column = Array();
        public $bddtable = "step1";

        public function __construct($pdo){
            $infotable = $pdo->prepare('SHOW COLUMNS FROM '.$this->bddtable.';');
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
				$this->setHeader(new Header($infos["Field"], $i), $i);
				$this->setCol(new Column($i, $this->getHeader($i)->getValue(), Array()), $i);
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
				$this->identifier[$row] = new Identifier($this->cells[0][$row], $row);
				$row++;
			}
			for($j=0;$j<count($this->cells[0]);$j++){
                for($i=0;$i<count($this->header);$i++){
                    $tempcells[$i] = $this->cells[$i][$j];
                }
                $this->row[$j] = new Row($this->identifier[$j], $j, $tempcells);
            }
			for($j=0;$j<count($this->header);$j++){
                for($i=0;$i<count($this->identifier);$i++){
                    $tempcells[$i] = $this->cells[$j][$i];
                }
                $this->column[$j] = new Column($j, $this->header[$j], $tempcells);
            }
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
        public function getHeader($i){
            return $this->header[$i];
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

		//column
        public function initCol($header, $identifier, $cells){
            for($j=0;$j<count($header);$j++){
                for($i=0;$i<count($identifier);$i++){
                    $tempcells[$j] = $cells[$j][$i];
                }
                $this->column[$j] = new Column($j, $header[$j]->getValue(), $tempcells);
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
			$req = $pdo->prepare("CREATE TABLE IF NOT EXISTS `step1` (`numero_du_patient` int(11) DEFAULT NULL, `prenom` varchar(6) DEFAULT NULL, `nom` varchar(13) DEFAULT NULL, `sexe` enum('M','F','N/P') DEFAULT NULL, `date_de_naissance` date DEFAULT NULL, `groupe_sanguin` varchar(2) DEFAULT NULL, `pourcent_mutation` int(11) DEFAULT NULL, `mutation` tinyint(1) DEFAULT NULL, `deces` tinyint(1) DEFAULT NULL, `date_de_deces` date DEFAULT NULL)");
            $req->execute();
		}
    }
?>