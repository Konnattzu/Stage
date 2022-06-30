<?php
    class Column{
        private $colnumb;
        private $colhead;
        private $cells = Array();
        private $datatype;
        private $datalength;
        private $pdo;

        public function __construct($numb, $head, $cells, $pdo){
            $this->pdo = $pdo;
            $this->initNumb($numb);
            $this->initHead($head);
            $this->initCells($cells);
            $this->initType($pdo);
            $this->initLen();
        }

        //column number
        public function initNumb($colnumb){
            $this->colnumb = $colnumb;
        }
        public function setNumb($colnumb){
            $this->colnumb = $colnumb;
        }
        public function getNumb(){
            return $this->colnumb;
        }

        //column head
        public function initHead($name){
            $this->colhead = $name;
        }
        public function setHead($name){
            $this->colhead = $name;
        }
        public function getHead(){
            return $this->colhead;
        }

        //cells
        public function initCells($cells){
            if($cells != ""){
                for($i=0;$i<count($cells);$i++){
                    $this->cells[$i] = $cells[$i];
                }
            }
        }
        public function setCells($cells){
            if($cells != ""){
                for($i=0;$i<count($cells);$i++){
                    $this->cells[$i] = $cells[$i];
                }
            }
        }
        public function getCells(){
            return $this->cells;
        }

        //datatype
        public function initType(){
            $type = Array();
            $enum = Array();
            if(is_countable($this->cells)){
                for($i=0;$i<count($this->cells);$i++){
                    $type[$i] = $this->cells[$i]->getType();
                }
                if($this->datatype != "enum"){
                    if(in_array("varchar", $type)){
                        $this->datatype = "varchar";
                    }else if(in_array("int", $type)){
                        $this->datatype = "int";
                    }else if(in_array("date", $type)){
                        $this->datatype = "date";
                    }else if(in_array("tinyint", $type)){
                        $this->datatype = "tinyint";
                    }else{
                        $this->datatype = "varchar";
                    }
                }
                for($i=0;$i<count($this->cells);$i++){
                    $enum[count($enum)] = $this->cells[$i]->getValue();
                    // print_r($enum);
                    // print_r($this->cells[$i]->getValue());
                    if(count($enum)>0){
                        for($k=0;$k<count($enum)-1;$k++){
                            // print_r($enum[$k]);
                            // echo'<br>';
                            // print_r($this->cells[$i]->getValue());
                            // echo' ';
                            if($enum[$k] == $this->cells[$i]->getValue()){
                                unset($enum[count($enum)-1]);
                            }
                        }
                    }
                    if(($this->datatype == "tinyint") && ($this->cells[$i]->getValue() != "oui") && ($this->cells[$i]->getValue() != "non") && ($this->cells[$i]->getValue() != "1") && ($this->cells[$i]->getValue() != "0")){
                        $this->cells[$i]->getCom()->setValue(trim(preg_replace("/(oui|non|1|0)/", " ", $this->cells[$i]->getValue())), $this->pdo);
                        // $cells[$i]->setValue(str_replace($comment, " ", $cells[$i]->getValue()));
                        // $cells[$i]->setValue(trim($cells[$i]->getValue()));
                    }
                }
                // echo'enum';
                // print_r($enum);
                // print_r(count($enum));
                // print_r($this->getHead());
                if(count($this->cells)>16){
                    if(count($enum)<8 && ($this->datatype == "varchar" || $this->datatype == "int") && count($enum)>0){
                        $this->datatype = "enum";
                        $datalength = "";
                        for($k=0;$k<count($enum)-1;$k++){
                            $datalength .= "'".$enum[$k]."', ";
                        }
                        $datalength .= "'".$enum[$k]."'";
                        $this->datalength = $datalength;
                    }
                }else{
                    if(count($enum)<(count($this->cells)*0.5) && ($this->datatype == "varchar" || $this->datatype == "int") && count($enum)>0){
                        $this->datatype = "enum";
                        $datalength = "";
                        for($k=0;$k<count($enum)-1;$k++){
                            $datalength .= "'".$enum[$k]."', ";
                        }
                        $datalength .= "'".$enum[$k]."'";
                        $this->datalength = $datalength;
                    }
                }
                if($this->datatype != "enum"){
                    if(in_array("varchar", $type)){
                        $this->datatype = "varchar";
                    }else if(in_array("int", $type)){
                        $this->datatype = "int";
                    }else if(in_array("date", $type)){
                        $this->datatype = "date";
                    }else if(in_array("tinyint", $type)){
                        $this->datatype = "tinyint";
                    }else{
                        $this->datatype = "varchar";
                    }
                }
            }
            // echo'<pre>';
            // print_r($this);
            // echo'</pre>';
        }
        public function setType($type){
            $this->datatype = $type;
        }
        public function getType(){
            return $this->datatype;
        }

        //datalength
        public function initLen(){
            if($this->datatype != "enum"){
                $this->datalength = 0;
            }
        }
        public function setLen($value){
            $this->datalength = datalength($value, "", 0);
        }
        public function getLen(){
            return $this->datalength;
        }
    }
?>