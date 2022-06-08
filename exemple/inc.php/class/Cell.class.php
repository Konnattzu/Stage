<?php
    class Cell{
        private $value;
        private $datatype;
        private $datalength;
        private $rownumb;
        private $colnumb;
        private $comment;

        public function __construct($value, $rownumb, $colnumb){
            $this->setValue($value);
            $this->setType($value);
            $this->setLen($value);
            $this->setRownb($rownumb);
            $this->setColnb($colnumb);
            $this->setCom($rownumb, $colnumb);
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

        public function setLen($value){
            $this->datalength = datalength($value, "", 0);
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

        public function setCom($rownumb, $colnumb){
            $comtext = "jesuisuncommentaire";
            $this->comment = new Comment($comtext, $rownumb, $colnumb);
        }
        public function getCom(){
            return $this->comment;
        }
    }
?>