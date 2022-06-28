<?php
    class Row{
        private $rownumb;
        private $rowid;
        private $cells = Array();

        public function __construct($name, $numb, $cells){
            $this->setNumb($numb);
            $this->setId($name);
            $this->setCells($cells);
        }

        public function setNumb($colnumb){
            $this->rownumb = $colnumb;
        }
        public function getNumb(){
            return $this->rownumb;
        }

        public function setId($name){
            $this->rowid = $name;
        }
        public function getId(){
            return $this->rowid;
        }

        public function setCells($cells){
            for($i=0;$i<count($cells);$i++){
                $this->cells[$i] = $cells[$i];
            }
        }
        public function getCells(){
            return $this->cells;
        }
    }
?>