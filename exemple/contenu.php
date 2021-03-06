<?php
	if(defined("constante")){
		session_start();
		include("bddconnect.php");
		include("inc.php/func/datatype.func.php");
		include("inc.php/func/clear.func.php");
		include("inc.php/class/Spreadsheet.class.php");
		include("inc.php/class/BDDsheet.class.php");
		include("inc.php/class/Header.class.php");
		include("inc.php/class/Cell.class.php");
		include("inc.php/class/Identifier.class.php");
		include("inc.php/class/Row.class.php");
		include("inc.php/class/Column.class.php");
		include("inc.php/class/Comment.class.php");
		include("inc.php/class/Graph.class.php");
		include("inc.php/class/Login.class.php");
		include("inc.php/class/User.class.php");
		include("inc.php/class/Patient.class.php");
		if(isset($_GET) && isset($_GET["ref"])) {
			$page = $_GET["ref"];
		}else{
			header("Location: index.php?ref=accueil");
		}
		if(isset($page) && ($page == "deconnexion")){
			include("inc.php/logout.inc.php");
		}
		echo'<!DOCTYPE html>
		<html lang="fr">
		<head>';
		include('head.php');
		echo'</head>
			<body>';
			if(isset($page) && $page != "kaplan" && $page != "sankey"){
				include('inc.php/header.inc.php');
				include('inc.php/menu.inc.php');
			}
		if(isset($page) && ($page != "")) {
			$_SESSION["currentpage"] = $page;
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
			include('inc.php/parts/db_backup.inc.php');
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
				case "login":
					include("inc.php/login.inc.php");
				break;
				case "compte":
					include("inc.php/compte.inc.php");
				break;
				case "fiche":
					include("inc.php/fiche.inc.php");
				break;
				case "kaplan":
					$dispgraph = new Graph();
					$dispgraph->setType($page);
					include("inc.php/graph.inc.php");
				break;
				case "sankey":
					$dispgraph = new Graph();
					$dispgraph->setType($page);
					include("inc.php/graph.inc.php");
				break;
			}
		}
		if(isset($page) && $page != "kaplan" && $page != "sankey"){
			include("inc.php/footer.inc.php");
		}
				echo'</body>
	</html>';
	}
	else die("");
?>
