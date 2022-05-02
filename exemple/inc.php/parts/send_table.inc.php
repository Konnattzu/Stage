<?php
	include("../../bddconnect.php");
	include("clear.func.php");
	include("datatype.func.php");
	$column = clear($_POST["column"]);
	$value = $_POST["value"];
	$idcolumn = clear($_POST["idcolumn"]);
	$row = $_POST["row"];
	$editplace = $_POST["editplace"];
	
	//get datalist
	//get headers list
	//for each id, verify if it exists
	//if yes, update
	//else, insert
	//for each data
	//find the more approaching column name in the db
	//verify if type correspond with the column 
	//verify if charlen correspond with the column 
	//if not, increase column charlen
	//send data on the right column name
	
	mysqli_query($mysqli, 'INSERT INTO step1 SELECT * FROM step2 WHERE '.$idcolumn.'="'.$row.'";');
?>