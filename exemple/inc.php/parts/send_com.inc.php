<?php
	include("../../bddconnect.php");
	include("../func/clear.func.php");
	include("../func/datatype.func.php");
	$row = $_POST['row'];
	$header = $_POST['column'];
	$comment = $_POST['comt'];
	$query = $pdo->prepare('SELECT * FROM commentaires WHERE identifiant="'.$row.'" AND colonne="'.$header.'";');
	$query->execute();
	$numrows = $query->fetch(PDO::FETCH_ASSOC);
	if($numrows>=1){
		echo 'UPDATE commentaires SET commentaire="'.$comment.'" WHERE identifiant="'.$row.'" AND colonne="'.$header.'";';
		$query = 'UPDATE commentaires SET commentaire="'.$comment.'" WHERE identifiant="'.$row.'" AND colonne="'.$header.'";';
        $pdo->exec($query);
	}else{
		echo "INSERT INTO commentaires (identifiant, colonne, commentaire) VALUES ('".$row."', '".$header."', '".$comment."');";
		$query = 'INSERT INTO commentaires (identifiant, colonne, commentaire) VALUES ("'.$row.'", "'.$header.'", "'.$comment.'");';
        $pdo->exec($query);
	}
	
	
?>