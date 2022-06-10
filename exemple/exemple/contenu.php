<?php
	if(defined("constante")){
		session_start();
		include("bddconnect.php");
		echo'<!DOCTYPE html>
		<html lang="fr">
		<head>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>';
		if(isset($_GET) && isset($_GET["ref"]) && ($_GET["ref"] != "")) {
			$page = $_GET["ref"];
			$_SESSION["currentpage"] = $page;
			include('head.php');
			echo'</head>
			<body>
				<header>';
			include('inc.php/header.inc.php');
			echo'</header>';
			if($_SESSION["currentpage"] != "saisie"){
				if(isset($_SESSION["path"])){
					if(file_exists($_SESSION["path"])){
						unlink($_SESSION["path"]);					
					}
					unset($_SESSION["path"]);	
				}
				if(isset($_SESSION["csv"])){
					unset($_SESSION["csv"]);
				}
			}
			switch($page){
				case "accueil":
					include("inc.php/accueil.inc.php");
				break;
				case "liste":
					include("inc.php/liste.inc.php");
				break;
				case "saisie":
					include("inc.php/table.inc.php");
				break;
			}
		} else { 
			$page = "accueil";
			header("Location: index.php?ref=".$page.""); 
		}
		echo'<footer>';
		include("inc.php/footer.inc.php");
		
				echo'</footer>
				</body>
	</html>';
	}
	else die("");
?>