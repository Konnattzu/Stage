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
            $value = clear($value);
            if(strlen($value) > 64){
                $value = substr($value, 0, 64);
            }
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

        public function setGroup($group){
            $this->group = $group;
        }
        public function getGroup(){
            return $this->group;
        }
    }
?>