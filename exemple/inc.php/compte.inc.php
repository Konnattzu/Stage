<?php
	if(defined("constante")){
        if((isset($_GET) && isset($_GET["user"])) || isset($_SESSION['user_id'])){
            if($_GET["user"] != ""){
                $_SESSION['user_id'] = $_GET["user"];
            }
            $user_id = $_SESSION['user_id'];
            $profile = new User($user_id, $pdo);
            $profile->displayHtml();
            echo'<a href="index.php?ref=deconnexion">Se déconnecter</a>';
        }else{
            include("inc.php/login.inc.php");
        }
    }
	else die("");
?>