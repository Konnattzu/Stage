<?php
    class Header{
        private $value;
        private $headnumb;
        private $group;

        public function __construct($value, $numb, $group){
            $this->setValue($value);
            $this->setNumb($numb);
            $this->setGroup($group);

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

        public function setGroup($group){
            $this->group = $group;
        }
        public function getGroup(){
            return $this->group;
        }
    }
?>