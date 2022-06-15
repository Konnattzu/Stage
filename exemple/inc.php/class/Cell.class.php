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
            $this->setType($value);
            $this->setLen($value);
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

        public function setType($value){
            $this->datatype = datatype($value, "");
        }
        public function getType(){
            return $this->datatype;
        }

        public function setLen(){
            $this->datalength = datalength($this->value, $this->datatype, 0);
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
        }
        public function getRowid(){
            return $this->rowid;
        }

        public function setColid($colid){
            $this->colid = $colid;
        }
        public function getColid(){
            return $this->colnumb;
        }

        public function setCom($rowid, $colid, $pdo){
            $this->comment = new Comment($rowid, $colid, $pdo);
        }
        public function getCom(){
            return $this->comment;
        }
    }
?>