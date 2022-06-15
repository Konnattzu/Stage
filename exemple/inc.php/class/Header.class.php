<?php
    class Header{
        private $value;
        private $headnumb;

        public function __construct($value, $numb){
            $this->setValue($value);
            $this->setNumb($numb);
        }

        public function setValue($value){
            $this->value = clear($value);
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
    }
?>