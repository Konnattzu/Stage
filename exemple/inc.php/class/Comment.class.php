<?php
    class Comment{
        private $value;
        private $rownumb;
        private $colnumb;

        public function __construct($value, $rownumb, $colnumb){
            $this->setValue($value);
            $this->setRownb($rownumb);
            $this->setColnb($colnumb);
        }

        public function setValue($value){
            $this->value = $value;
        }
        public function getValue(){
            return $this->value;
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
    }
?>