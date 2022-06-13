<?php
    class Comment{
        private $value;
        private $rowid;
        private $colid;

        public function __construct($rowid, $colid, $pdo){
            $this->setValue($rowid, $colid, $pdo);
            $this->setRownb($rowid);
            $this->setColnb($colid);
        }

        public function setValue($rowid, $colid, $pdo){
            $req = $pdo->prepare('SELECT * FROM commentaires WHERE patient_id="'.$rowid.'" AND colonne="'.$colid.'";');
			$req->execute();
			while($com = $req->fetch(PDO::FETCH_ASSOC)){
				$this->value = $com['commentaire'];
			}
        }
        public function getValue(){
            return $this->value;
        }

        public function setRownb($rowid){
            $this->rowid = $rowid;
        }
        public function getRownb(){
            return $this->rowid;
        }

        public function setColnb($colid){
            $this->colid = $colid;
        }
        public function getColnb(){
            return $this->colid;
        }
    }
?>