<?php
    class User{
        private $user_id;
        private $nom;
        private $prenom;
        private $mail;
        private $modlvl;
        private $role;
        private $user_img;
        private $table = "users";
        private $html;
        private $pdo;

        public function __construct($user_id, $pdo){
            $this->pdo = $pdo;
            $this->user_id = $user_id;
            $this->initNom();
            $this->initPrenom();
            $this->initMail();
            $this->initLvl();
            $this->initRole();
            $this->initImage();
            $this->initHtml();
        }

        public function setId($id){
            $this->user_id = $id;
        }
        public function getId(){
            return $this->user_id;
        }

        public function initNom(){
            $query = $this->pdo->prepare('SELECT nom FROM users WHERE user_id="'.$this->user_id.'";');
            $query->execute();
            $infos = $query->fetch(PDO::FETCH_NUM);
            $this->nom = $infos[0];
        }
        public function setNom($nom){
            $this->nom = $nom;
        }
        public function getNom(){
            return $this->nom;
        }

        public function initPrenom(){
            $query = $this->pdo->prepare('SELECT prenom FROM users WHERE user_id="'.$this->user_id.'";');
            $query->execute();
            $infos = $query->fetch(PDO::FETCH_NUM);
            $this->prenom = $infos[0];
        }
        public function setPrenom($prenom){
            $this->prenom = $prenom;
        }
        public function getPrenom(){
            return $this->prenom;
        }

        public function initMail(){
            $query = $this->pdo->prepare('SELECT mail FROM users WHERE user_id="'.$this->user_id.'";');
            $query->execute();
            $infos = $query->fetch(PDO::FETCH_NUM);
            $this->mail = $infos[0];
        }
        public function setMail($mail){
            $this->mail = $mail;
        }
        public function getMail(){
            return $this->mail;
        }

        public function initLvl(){
            $query = $this->pdo->prepare('SELECT modlvl FROM users WHERE user_id="'.$this->user_id.'";');
            $query->execute();
            $infos = $query->fetch(PDO::FETCH_NUM);
            $this->modlvl = $infos[0];
        }
        public function setLvl($modlvl){
            $this->modlvl = $modlvl;
        }
        public function getLvl(){
            return $this->modlvl;
        }

        public function initRole(){
            switch($this->modlvl){
                case 1:
                    $this->role = "Etudiant";
                break;
                case 2:
                    $this->role = "Chercheur";
                break;
                case 3:
                    $this->role = "Chef d'unité";
                break;
            }
        }
        public function setRole($role){
            $this->role = $role;
        }
        public function getRole(){
            return $this->role;
        }

        public function initImage(){
            $query = $this->pdo->prepare('SELECT profil_img FROM users WHERE user_id="'.$this->user_id.'";');
            $query->execute();
            $infos = $query->fetch(PDO::FETCH_NUM);
            $req = $this->pdo->prepare('SELECT image_path FROM images WHERE image_id="'.$infos[0].'";');
            $req->execute();
            $image = $req->fetch(PDO::FETCH_NUM);
             $this->user_img = $image[0];
        }
        public function setImage($img){
            $this->user_img = $img;
        }
        public function getImage(){
            return $this->user_img;
        }

        public function setTable($table){
            $this->table = $table;
        }
        public function getTable(){
            return $this->table;
        }

        public function initHtml(){
            $html = '<h2>Bienvenue '.$this->prenom.' '.$this->nom.' !</h2>
            <img src="'.$this->user_img.'" alt="image_de_profil">
            <section>Statut: '.$this->role.'</section>
            <section>Adresse e-mail: '.$this->mail.'</section>';
            $this->html = $html;
        }
        public function setHtml($html){
            $this->html = $html;
        }
        public function getHtml(){
            return $this->html;
        }

        public function displayHtml(){
            echo $this->html;
        }
    }
?>