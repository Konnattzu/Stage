<?php
    class Comment{
        private $value;
        private $rowid;
        private $colid;

        public function __construct($rowid, $colid, $pdo){
            $this->valueInit($rowid, $colid, $pdo);
            $this->setRowid($rowid);
            $this->setColid($colid);
        }

        public function valueInit($rowid, $colid, $pdo){
            $req = $pdo->prepare('SELECT * FROM commentaires WHERE identifiant="'.$rowid.'" AND colonne="'.$colid.'";');
			$req->execute();
			while($com = $req->fetch(PDO::FETCH_ASSOC)){
				$this->value = $com['commentaire'];
			}
        }
        public function setValue($value, $pdo){
            if($value != ""){
                echo'INSERT INTO commentaires(identifiant, colonne, commentaire) VALUES ('.$this->rowid.', '.$this->colid.', '.$value.');';
                $req = $pdo->prepare('INSERT INTO commentaires(identifiant, colonne, commentaire) VALUES ('.$this->rowid.', '.$this->colid.', '.$value.');');
                $req->execute();
                $this->value = $value;
            }
        }
        public function getValue(){
            return $this->value;
        }

        public function setRowid($rowid){
            $this->rowid = $rowid;
        }
        public function getRowid(){
            return $this->rowid;
        }

        public function setColid($colid){
            $this->colid = $colid;
        }
        public function getColid(){
            return $this->colid;
        }
    }
?>