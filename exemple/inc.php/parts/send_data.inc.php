<?php
	include("../../bddconnect.php");
	include("clear.func.php");
	include("datatype.func.php");
	$column = clear($_POST["column"]);
	$value = $_POST["value"];
	$idcolumn = clear($_POST["idcolumn"]);
	$row = $_POST["row"];
	$editplace = $_POST["editplace"];
	if($editplace == "liste"){
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
		}
		if($column != $idcolumn && ($row != "" && !empty($row))){
			if(mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM step1 WHERE ".$idcolumn."='".$row."';"))>=1){
				mysqli_query($mysqli, "UPDATE step1 SET ".$column."='".$value."' WHERE ".$idcolumn."='".$row."';");
			}
		}else if($column == $idcolumn && ($row != "" && !empty($row))){
			// echo "insert";
			mysqli_query($mysqli, "INSERT INTO step1 (".$column.") VALUES ('".$value."');");
		}
	}else if($editplace == "saisie"){
		$infotable = mysqli_query($_SESSION["mysqli"], 'SELECT 
										TABLE_CATALOG,
										TABLE_SCHEMA,
										TABLE_NAME, 
										COLUMN_NAME, 
										DATA_TYPE, 
										COLUMN_TYPE, 
										CHARACTER_MAXIMUM_LENGTH
										FROM INFORMATION_SCHEMA.COLUMNS
										where TABLE_NAME = "step2" AND COLUMN_NAME = "'.$column.'";');
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
			mysqli_query($mysqli, "ALTER TABLE step2 MODIFY ".$column." ".$datatype." (".strlen($value).");");
		}
		if($column != $idcolumn && ($row != "" && !empty($row))){
			if(mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM step1 WHERE ".$idcolumn."='".$row."';"))>=1){
				mysqli_query($mysqli, "UPDATE step2 SET ".$column."='".$value."' WHERE ".$idcolumn."='".$row."';");
			}
		}else if($column == $idcolumn && ($row != "" && !empty($row))){
			mysqli_query($mysqli, "INSERT INTO step2 (".$column.") VALUES ('".$value."');");
		}
	}
	echo $value;
?>