<?php
	include("../../bddconnect.php");
	include("../func/clear.func.php");
	include("../func/datatype.func.php");
	$row = $_POST['row'];
	$header = $_POST['column'];
	$comment = $_POST['comt'];
	$query = $pdo->prepare('SELECT * FROM commentaires WHERE patient_id="'.$row.'" AND colonne="'.$header.'";');
	$query->execute();
	$numrows = $query->fetch(PDO::FETCH_ASSOC);
	if($numrows>=1){
		echo 'UPDATE commentaires SET patient_id="'.$row.'", colonne="'.$header.'", commentaire="'.$comment.'";';
		$query = 'UPDATE commentaires SET patient_id="'.$row.'", colonne="'.$header.'", commentaire="'.$comment.'";';
        $pdo->exec($query);
	}else{
		echo "INSERT INTO commentaires (patient_id, colonne, commentaire) VALUES ('".$row."', '".$header."', '".$comment."');";
		$query = 'INSERT INTO commentaires (patient_id, colonne, commentaire) VALUES ("'.$row.'", "'.$header.'", "'.$comment.'");';
        $pdo->exec($query);
	}
	
	
?>