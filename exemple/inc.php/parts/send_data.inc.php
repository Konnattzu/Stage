<?php
	include("../../bddconnect.php");
	include("clear.func.php");
	include("datatype.func.php");
	$column = clear($_POST["column"]);
	$value = $_POST["value"];
	$idcolumn = clear($_POST["idcolumn"]);
	$row = $_POST["row"];
	$req = "UPDATE step1 SET ".$column."='".$value."' WHERE ".$idcolumn."='".$row."';";
	$infotable = mysqli_query($_SESSION["mysqli"], 'SELECT 
									TABLE_CATALOG,
									TABLE_SCHEMA,
									TABLE_NAME, 
									COLUMN_NAME, 
									DATA_TYPE, 
									COLUMN_TYPE, 
									CHARACTER_MAXIMUM_LENGTH
									FROM INFORMATION_SCHEMA.COLUMNS
									where TABLE_NAME = "step1" AND COLUMN_NAME = "'.$column.'";');
									$i = 0;
	while($infos = $infotable->fetch_assoc()){
		$coltype = $infos["COLUMN_TYPE"];
		$charlength[$column] = $infos["CHARACTER_MAXIMUM_LENGTH"];
		$i++;
	}
	if(!empty($charlength[$column]) && strlen($value) > $charlength[$column]){
		$type = preg_replace("/[^A-Za-z]/", "", $coltype);
		$len = $string = preg_replace("/[^0-9]/", "", $coltype);
		$datatype = datatype($value, $type, $len);
		mysqli_query($mysqli, "ALTER TABLE step1 MODIFY ".$column." ".$datatype." (".strlen($value).");");
		mysqli_query($mysqli, "ALTER TABLE step2 MODIFY ".$column." ".$datatype." (".strlen($value).");");
	}
	if(mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM step2 WHERE ".$idcolumn."='".$row."';"))>=1){
		mysqli_query($mysqli, str_replace("step1", "step2", $req));
	}
	mysqli_query($mysqli,$req);
	echo $value;
?>