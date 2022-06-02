<?php
	include("../../bddconnect.php");
	include("clear.func.php");
	include("datatype.func.php");
	$rows = Array();
	$header = Array();
	$comment = Array();
	$response = "";
	$rows = json_decode($_POST['rows']);
	$header = json_decode($_POST['header']);
	for($i=0;$i<count($rows);$i++){
		for($j=0;$j<count($header);$j++){
		$req = mysqli_query($mysqli, "SELECT * FROM commentaires WHERE patient_id='".$rows[$i][0]."' AND colonne='".$header[$j]."';");
			while($com = $req->fetch_assoc()){
				$comment[$i][$j] = $com["commentaire"];
				$response = json_encode($comment).'£';
			}
		}
	}
	$response = str_replace("}£{", ", ", $response);
	$response = trim($response, "£");
	echo $response;
?>