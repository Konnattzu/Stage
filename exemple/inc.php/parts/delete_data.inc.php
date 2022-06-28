<?php
	include("../../bddconnect.php");
	include("../func/clear.func.php");
	include("../func/datatype.func.php");
	$idcolumn = clear($_POST["idcolumn"]);
	$row = $_POST["row"];
	$editplace = $_POST["editplace"];
	if($editplace == "liste"){
		$query = $pdo->prepare("SELECT * FROM step1 WHERE ".$idcolumn."='".$row."';");
		$query->execute();
		$numrows = count($query->fetch(PDO::FETCH_ASSOC));
		if($numrows <= 1){
			$query = "DELETE FROM step1 WHERE ".$idcolumn."='".$row."';";
        	$pdo->exec($query);
		}else{
			$query = "DELETE FROM step1 WHERE ".$idcolumn."='".$row."' LIMIT ".($numrows-1).";";
        	$pdo->exec($query);
		}
	}else if($editplace == "saisie"){
		$query = $pdo->prepare("SELECT * FROM step2 WHERE ".$idcolumn."='".$row."';");
		$query->execute();
		$numrows = count($query->fetch(PDO::FETCH_ASSOC));
		if($numrows <= 1){
			$query = "DELETE FROM step2 WHERE ".$idcolumn."='".$row."';";
        	$pdo->exec($query);
		}else{
			echo $numrows;
			$query = "DELETE FROM step2 WHERE ".$idcolumn."='".$row."' LIMIT ".($numrows-1).";";
        	$pdo->exec($query);
		}
	}
?>