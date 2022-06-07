<?php
    class Spreadsheet{
        private $header;
        private $identifier;
        private $row;
        private $column;
        private $cell;

        public function __construct($header, $identifier, $row, $column, $cell){
            $this->setHeader($header);
            $this->setId($identifier);
            $this->setRow($row);
            $this->setCol($column);
            $this->setCell($cell);
        }

        public function setHeader(){
            $this->header = $header;
        }
        public function getHeader(){
            return $this->header;
        }

        public function setId(){
            $this->header = $header;
        }
        public function getId(){
            return $this->header;
        }

        public function setRow(){
            $this->header = $header;
        }
        public function getRow(){
            return $this->header;
        }

        public function setCol(){
            $this->header = $header;
        }
        public function getCol(){
            return $this->header;
        }

        public function setCell(){
            $this->header = $header;
        }
        public function getCell(){
            return $this->header;
        }

        public function createTable($file){
            
        }

        public function addData($file){
            
        }

        public function headerSet($file){
            
        }

        public function dataSet($file){
            
        }
    }
?>