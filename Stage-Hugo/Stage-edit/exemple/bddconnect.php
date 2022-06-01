<?php	
	$BDD = array();
	$BDD['host'] = "localhost";
	$BDD['user'] = "root";
	$BDD['pass'] = "bagnoletmmi76";
	$BDD['db'] = "exemple";
	$mysqli = mysqli_connect($BDD['host'], $BDD['user'], $BDD['pass'], $BDD['db']);
	$mysqli->set_charset("utf8");
	$_SESSION["mysqli"] = $mysqli;
?>