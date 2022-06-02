<?php	
	$BDD = array();
	$BDD['host'] = "localhost";
	$BDD['user'] = "12002444";
	$BDD['pass'] = "070879959HF";
	$BDD['db'] = "U978_insermdb";
	$mysqli = mysqli_connect($BDD['host'], $BDD['user'], $BDD['pass'], $BDD['db']);
	$mysqli->set_charset("utf8");
	$_SESSION["mysqli"] = $mysqli;
?>
