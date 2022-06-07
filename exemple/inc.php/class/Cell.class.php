<?php
    class Cell{
        private $value;
        private $headnumb;
        private $datatype;
        private $datalength;
        private $rownumb;
        private $colnumb;
        private $comment;

        public function __construct($value, $numb){
            $this->setValue($value);
            $this->setNumb($numb);
            $this->setType($value);
            $this->setLen($value);
        }

        public function setValue($value){
            $this->value = $value;
        }
        public function getValue(){
            return $this->value;
        }

        public function setNumb($headnumb){
            $this->headnumb = $headnumb;
        }
        public function getNumb(){
            return $this->headnumb;
        }

        public function setType($value){
            $this->datatype = datatype($value);
        }
        public function getType(){
            return $this->datatype;
        }

        public function setLen($value){
            $this->datalength = datalength($value);
        }
        public function getLen(){
            return $this->datalength;
        }

        public function setLen($numb){
            $this->rownumb = datalength($numb);
        }
        public function getLen(){
            return $this->rownumb;
        }

        public function setLen($numb){
            $this->colnumb = datalength($numb);
        }
        public function getLen(){
            return $this->colnumb;
        }

        public function setLen($rownumb, $colnumb){
            $this->comment = datalength($numb);
        }
        public function getLen(){
            return $this->comment;
        }
    }
?>