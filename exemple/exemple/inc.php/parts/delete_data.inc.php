<?php
	include("../../bddconnect.php");
	include("clear.func.php");
	include("datatype.func.php");
	$idcolumn = clear($_POST["idcolumn"]);
	$row = $_POST["row"];
	$editplace = $_POST["editplace"];
	if($editplace == "liste"){
		$numrows = mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM step1 WHERE ".$idcolumn."='".$row."';"));
		if($numrows <= 1){
			mysqli_query($mysqli, "DELETE FROM step1 WHERE ".$idcolumn."='".$row."';");
		}else{
			mysqli_query($mysqli, "DELETE FROM step1 WHERE ".$idcolumn."='".$row."' LIMIT ".($numrows-1).";");
		}
	}else if($editplace == "saisie"){
		$numrows = mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM step2 WHERE ".$idcolumn."='".$row."';"));
		if($numrows <= 1){
			mysqli_query($mysqli, "DELETE FROM step2 WHERE ".$idcolumn."='".$row."';");
		}else{
			mysqli_query($mysqli, "DELETE FROM step2 WHERE ".$idcolumn."='".$row."' LIMIT ".($numrows-1).";");
		}
	}
?>