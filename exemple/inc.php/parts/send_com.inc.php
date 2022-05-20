<?php
	include("../../bddconnect.php");
	include("clear.func.php");
	include("datatype.func.php");
	$row = $_POST['row'];
	$header = $_POST['column'];
	$comment = $_POST['comt'];
	if(mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM commentaires WHERE patient_id='".$row."' AND colonne='".$header."';"))>=1){
		mysqli_query($mysqli, "UPDATE patient_id='".$row."', colonne='".$header."', commentaire='".$comment."';");	
	echo "UPDATE patient_id='".$row."', colonne='".$header."', commentaire='".$comment."';";
	}else{
		mysqli_query($mysqli, "INSERT INTO commentaires (patient_id, colonne, commentaire) VALUES ('".$row."', '".$header."', '".$comment."');");	
	echo "INSERT INTO commentaires (patient_id, colonne, commentaire) VALUES ('".$row."', '".$header."', '".$comment."');";
	}
	
	
?>