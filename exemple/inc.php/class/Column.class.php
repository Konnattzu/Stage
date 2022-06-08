<?php
    class Column{
        private $colnumb;
        private $colname;
        private $cells = Array();
        private $datatype;
        private $datalength;

        public function __construct($name, $numb, $cells){
            $this->setNumb($numb);
            $this->setName($name);
            $this->setCells($cells);
            $this->setType($name);
            $this->setLen($name);
        }

        public function setNumb($colnumb){
            $this->colnumb = $colnumb;
        }
        public function getNumb(){
            return $this->colnumb;
        }

        public function setName($name){
            $this->colname = $name;
        }
        public function getName(){
            return $this->colname;
        }

        public function setCells($cells){
            for($i=0;$i<count($cells);$i++){
                $this->cells[$i] = $cells[$i];
            }
        }
        public function getCells(){
            return $this->cells;
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
    }
?>