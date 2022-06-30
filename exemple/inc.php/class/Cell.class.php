<?php
    class Cell{
        private $value;
        private $datatype;
        private $datalength;
        private $rownumb;
        private $colnumb;
        private $rowid;
        private $colid;
        private $comment;

        public function __construct($value, $rownumb, $colnumb, $colid, $rowid, $pdo){
            $this->setValue($value);
            $this->initType();
            $this->initLen();
            $this->setRownb($rownumb);
            $this->setColnb($colnumb);
            $this->setRowid($rowid);
            $this->setColid($colid);
            $this->setCom($rowid, $colid, $pdo);
        }

        public function setValue($value){
            $this->value = $value;
        }
        public function getValue(){
            return $this->value;
        }

        public function initType(){
            $this->datatype = datatype($this->value, "");
        }
        public function setType($value){
            $this->datatype = $value;
        }
        public function getType(){
            return $this->datatype;
        }

        public function initLen(){
            $this->datalength = datalength($this->value, $this->datatype, 0);
        }
        public function setLen($len){
            $this->datalength = $len;
        }
        public function getLen(){
            return $this->datalength;
        }

        public function setRownb($rownumb){
            $this->rownumb = $rownumb;
        }
        public function getRownb(){
            return $this->rownumb;
        }

        public function setColnb($colnumb){
            $this->colnumb = $colnumb;
        }
        public function getColnb(){
            return $this->colnumb;
        }

        public function setRowid($rowid){
            $this->rowid = $rowid;
            if(isset($this->comment)){
                $this->comment->setRowid($rowid);
            }
        }
        public function getRowid(){
            return $this->rowid;
        }

        public function setColid($colid){
            $this->colid = $colid;
            if(isset($this->comment)){
                $this->comment->setColid($colid);
            }
        }
        public function getColid(){
            return $this->colid;
        }

        public function setCom($rowid, $colid, $pdo){
            $this->comment = new Comment($rowid, $colid, $pdo);
        }
        public function getCom(){
            return $this->comment;
        }

        public function senddata($column, $value, $row, $editplace){
            $column = clear($_POST["column"]);
            $value = $_POST["value"];
            $row = $_POST["row"];
            $editplace = $_POST["editplace"];
            if($editplace == "liste"){
                $infotable = $pdo->prepare('SHOW COLUMNS FROM step1;');
                $infotable->execute();
                $i = 0;
                while($infos = $infotable->fetch(PDO::FETCH_ASSOC)){
                    preg_match('/[a-z]+/', $infos['Type'], $type);
                    preg_match('/\d+/', $infos['Type'], $len);
                    if(!isset($type[0]) || $type[0] == ""){
                        $type[0] = "";
                    }
                    if(!isset($len[0]) || $len[0] == ""){
                        $len[0] = "";
                    }
                    $coltype = $type[0];
                    $charlength = $len[0];
                    $i++;
                }
                if(!empty($charlength) && strlen($value) > $charlength){
                    $type = preg_replace("/[^A-Za-z]/", "", $coltype);
                    $len = $string = preg_replace("/[^0-9]/", "", $coltype);
                    $datatype = datatype($value, $type, $len);
                    $query = "ALTER TABLE step1 MODIFY ".$column." ".$datatype." (".strlen($value).");";
                    $pdo->exec($query);
                }
                if($row != "" && !empty($row)){
                    $query = $pdo->prepare("SELECT * FROM step1 WHERE numero_du_patient='".$row."';");
                    $query->execute();
                    $numrows = $query->fetch(PDO::FETCH_ASSOC);
                    if($numrows>=1){
                        $query = "UPDATE step1 SET ".$column."='".$value."' WHERE numero_du_patient='".$row."';";
                        $pdo->exec($query);
                    }
                }else if($row == "" || empty($row) && $column == "numero_du_patient"){
                    echo"SELECT * FROM step1 WHERE numero_du_patient='".$value."';";
                    $query = $pdo->prepare("SELECT * FROM step1 WHERE numero_du_patient='".$value."';");
                    $query->execute();
                    $numrows = $query->fetch(PDO::FETCH_ASSOC);
                    if($numrows==0){
                        $query = "INSERT INTO step1 (numero_du_patient) VALUES ('".$value."');";
                        $pdo->exec($query);
                    }
                }
            }else if($editplace == "saisie"){
                $infotable = $pdo->prepare('SHOW COLUMNS FROM step2;');
                $infotable->execute();
                $i = 0;
                while($infos = $infotable->fetch(PDO::FETCH_ASSOC)){
                    preg_match('/[a-z]+/', $infos['Type'], $type);
                    preg_match('/\d+/', $infos['Type'], $len);
                    if(!isset($type[0]) || $type[0] == ""){
                        $type[0] = "";
                    }
                    if(!isset($len[0]) || $len[0] == ""){
                        $len[0] = "";
                    }
                    $coltype = $type[0];
                    $charlength = $len[0];
                    $i++;
                }
                if(!empty($charlength) && strlen($value) > $charlength){
                    $type = preg_replace("/[^A-Za-z]/", "", $coltype);
                    $len = $string = preg_replace("/[^0-9]/", "", $coltype);
                    $datatype = datatype($value, $type, $len);
                    $query = "ALTER TABLE step2 MODIFY ".$column." ".$datatype." (".strlen($value).");";
                    $pdo->exec($query);
                }
                if($row != "" && !empty($row)){
                    $query = $pdo->prepare("SELECT * FROM step2 WHERE numero_du_patient='".$row."';");
                    $query->execute();
                    $numrows = $query->fetch(PDO::FETCH_ASSOC);
                    if($numrows>=1){
                        $query = "UPDATE step2 SET ".$column."='".$value."' WHERE numero_du_patient='".$row."';";
                        $pdo->exec($query);
                    }
                }else if($row == "" || empty($row) && $column == "numero_du_patient"){
                    $query = $pdo->prepare("SELECT * FROM step2 WHERE numero_du_patient='".$value."';");
                    $query->execute();
                    $numrows = $query->fetch(PDO::FETCH_ASSOC);
                    if($numrows==0){
                        $query = "INSERT INTO step2 (numero_du_patient) VALUES ('".$value."');";
                        $pdo->exec($query);
                    }
                }
            }
            echo $value;
        }
    }
?>