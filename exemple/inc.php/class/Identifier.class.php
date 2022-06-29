<?php
    class Identifier{
        private $value;
        private $rownumb;

        public function __construct($value, $numb){
            $this->setValue($value);
            $this->setNumb($numb);
        }

        public function setValue($value){
            $this->value = $value;
        }
        public function getValue(){
            return $this->value;
        }

        public function setNumb($numb){
            $this->rownumb = $numb;
        }
        public function getNumb(){
            return $this->rownumb;
        }
    }
?>