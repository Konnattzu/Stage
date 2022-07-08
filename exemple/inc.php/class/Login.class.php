<?php
    class Login{
        private $table = "users";
        private $html = Array();
        private $pdo;

        public function __construct($pdo){
            $this->pdo = $pdo;
            $this->createTable();
            $this->initHtml();
        }

        public function setTable($name){
            $this->table = $name;
        }
        public function getTable(){
            return $this->table;
        }

        public function initHtml(){
            $html = Array();
            $html["connexion"] = '
            <div id="connexion" class="login">
                <div class="head">
                    <h3>Connectez vous à votre compte</h3>
                </div>
                <form id="connexion-form" action="" method="post">
                    <div class="identite">
                        <div class="nom">
                            <input type="name" name="nom" required>
                            <label>Nom</label>
                        </div>
                        <div class="nom">
                            <input type="name" name="prenom" required>
                            <label>Prénom</label>
                        </div>
                    </div>
                    <article class="pass-confimation">
                        <div class="pass">
                            <input type="password" class="password" id="pass" name="pass" required>
                            <label>Mot de passe</label>
                        </div>
                    </article>
                    <div class="iconeye">
                        <img src="images/eyehide.png" id="eye-conn">
                    </div>
                    <button class="connexion">
                        <input id="conn-btn" type="submit" name="connexion" value="Se connecter">
                    </button>
                </form>
            </div>';
            $html["inscription"] = '
            <div id="inscription" class="login">
                <div class="head">
                    <h3>Créez votre profil d\'utilisateur</h3>
                </div>
                <form id="inscription-form" action="" method="post">
                    <div class="identite">
                        <div class="field">
                            <input type="name" name="nom" required>
                            <label>Nom</label>
                        </div>
                        <div class="field">
                            <input type="name" name="prenom" required>
                            <label>Prénom</label>
                        </div>
                    </div>
                    <article class="pass-confimation">
                        <div class="field">
                            <input type="password" class="password" id="pass1" name="pass" required>
                            <label>Mot de passe</label>
                        </div>
                        <div class="field">
                            <input type="password" class="password" id="pass2" name="confpass" required>
                            <label>Confirmer le mot de passe</label>
                        </div>
                    </article>
                    <div class="iconeye">
                        <img src="images/eyehide.png" id="eye-insc">
                    </div>
                    <div class="other">
                        <div class="field">            
                            <input type="mail" id="mail" name="email">
                            <label>Adresse e-mail</label>
                        </div>
                        <div class="list"> 
                            <label>Position
                                <select name="lvl">
                                    <option value="1">Etudiant</option>
                                    <option value="2">Chercheur</option>
                                    <option value="3">Chef d\'unité</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <button class="inscription">
                        <input id="insc-btn" type="submit" name="inscription" value="S&apos;inscrire">
                    </button>
                </form>
            </div>';
            $this->html = $html;
        }
        public function setHtml($html, $place){
            $this->html[$place] = $html;
        }
        public function getHtml(){
            return $this->html;
        }

        public function setPDO($pdo){
            $this->pdo = $pdo;
        }
        public function getPDO(){
            return $this->pdo;
        }

        public function createTable(){
            $query = "CREATE TABLE IF NOT EXISTS `users` (
                `user_id` int(10) NOT NULL AUTO_INCREMENT,
                `nom` varchar(32) NOT NULL,
                `prenom` varchar(32) NOT NULL,
                `pass` varchar(32) NOT NULL,
                `mail` varchar(64) NOT NULL,
                `modlvl` int(10) NOT NULL,
                `profil_img` int(10) NOT NULL,
                PRIMARY KEY (`user_id`)
               ) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1";
            $create = $this->pdo->prepare($query);
            $create->execute();
            
            $query = "CREATE TABLE IF NOT EXISTS `images` (
                `image_id` int(11) NOT NULL AUTO_INCREMENT,
                `image_path` varchar(64) NOT NULL DEFAULT 'bddimg/default.png',
                PRIMARY KEY (`image_id`)
               ) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8
               ";
            $create = $this->pdo->prepare($query);
            $create->execute();
        }

        function json_encode_private() {
			echo'<script>
			login = new Login();
			login.dataFill('.json_encode($this->extract_props($this)).');
			</script>';
		}
        function stackVal($value, $name) {
            if(is_array($value)) {
                $public[$name] = [];

                foreach ($value as $item) {
                    if (is_object($item)) {
                        $itemArray = $this->extract_props($item);
                        $public[$name][] = $itemArray;
                    } else {
                        $itemArray = $this->stackVal($item, $name);
                         $public[$name][] = $itemArray;
                    }
                }
            } else if(is_object($value)) {
                $public[$name] = $this->extract_props($value);
            } else $public[$name] = $value;
            return $public[$name];
        }
        function extract_props($object) {
            $publicObj = [];
    
            $reflection = new ReflectionClass(get_class($object));
    
            
            
            foreach ($reflection->getProperties() as $property) {
                $property->setAccessible(true);
    
                $value = $property->getValue($object);
                $name = $property->getName();
                $publicObj[$name] = $this->stackVal($value, $name);
            }
            // echo'<pre>';
            // print_r($publicObj[$name]);
            // echo'</pre>';
    
            return $publicObj;
        }
    }
?>