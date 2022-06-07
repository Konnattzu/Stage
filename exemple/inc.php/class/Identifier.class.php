<?php
    class Header{
        private $value;
        private $headnumb;
        private $datatype;
        private $datalength;

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
    }
?>