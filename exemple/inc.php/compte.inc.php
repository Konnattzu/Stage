<?php
	if(defined("constante")){
        if((isset($_GET) && isset($_GET["user"])) || isset($_SESSION['user_id'])){
            if($_GET["user"] != ""){
                $_SESSION['user_id'] = $_GET["user"];
            }
            $user_id = $_SESSION['user_id'];
            $profile = new User($user_id, $pdo);
            $profile->displayHtml();
        }else{
            include("inc.php/login.inc.php");
        }
    }
	else die("");
?>