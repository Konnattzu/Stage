<?php
	include("../../bddconnect.php");
	include("clear.func.php");
	include("datatype.func.php");
	$idcolumn = clear($_POST["idcolumn"]);
	$row = $_POST["row"];
	$editplace = $_POST["editplace"];
	if($editplace == "liste"){
		mysqli_query($mysqli, "DELETE FROM step1 WHERE ".$idcolumn."='".$row."';");
	}else if($editplace == "saisie"){
		mysqli_query($mysqli, "DELETE FROM step2 WHERE ".$idcolumn."='".$row."';");
	}
?>