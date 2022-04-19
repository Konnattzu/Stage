<?php
	if(defined("constante")){
		session_start();
		include("inc.php/bddconnect.inc.php");
		echo'<!DOCTYPE html>
		<html lang="fr">
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>';
		if(isset($_GET) && isset($_GET["ref"]) && ($_GET["ref"] != "")) {
			$page = $_GET["ref"];
			$_SESSION["currentpage"] = $page;
			include('header.php');
			switch($page){
				case "accueil":
					include("inc.php/accueil.inc.php");
				break;
				case "liste":
					include("inc.php/liste.inc.php");
				break;
			}
		} else { 
			$page = "accueil";
			header("Location: index.php?ref=".$page.""); 
		}
		include("footer.php");
		
				echo'</body>
	</html>';
	}
	else die("");
?>
