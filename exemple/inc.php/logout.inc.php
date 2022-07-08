<?php
	if(defined("constante")){
		session_unset();
		session_destroy();
		header("Location: index.php?ref=accueil");
	}
	else die("");
?>
