<?php
	include("../../bddconnect.php");
	include("../func/clear.func.php");
	include("../func/datatype.func.php");
	$column = clear($_POST["column"]);
	$value = $_POST["value"];
	$row = $_POST["row"];
	$editplace = $_POST["editplace"];
	echo $column;
	echo $value;
	echo $row;
	echo $editplace;
	if($editplace == "liste"){
		$infotable = $pdo->prepare('SHOW COLUMNS FROM step1;');
		$infotable->execute();
		$i = 0;
		while($infos = $infotable->fetch(PDO::FETCH_ASSOC)){
			preg_match('/[a-z]+/', $infos['Type'], $type);
			preg_match('/\d+/', $infos['Type'], $len);
			if(!isset($type[0]) || $type[0] == ""){
				$type[0] = "";
			}
			if(!isset($len[0]) || $len[0] == ""){
				$len[0] = "";
			}
			$coltype = $type[0];
			$charlength = $len[0];
			$i++;
		}
		if(!empty($charlength) && strlen($value) > $charlength){
			$type = preg_replace("/[^A-Za-z]/", "", $coltype);
			$len = $string = preg_replace("/[^0-9]/", "", $coltype);
			$datatype = datatype($value, $type, $len);
			$query = "ALTER TABLE step1 MODIFY ".$column." ".$datatype." (".strlen($value).");";
			echo $query;
			$pdo->exec($query);
		}
		if($row != "" && !empty($row)){
			$query = $pdo->prepare("SELECT * FROM step1 WHERE numero_du_patient='".$row."';");
			$query->execute();
			$numrows = $query->fetch(PDO::FETCH_ASSOC);
			if($numrows>=1){
				$query = "UPDATE step1 SET ".$column."='".$value."' WHERE numero_du_patient='".$row."';";
				echo $query;
				$pdo->exec($query);
			}
		}else if($row == "" || empty($row) && $column == "numero_du_patient"){
			echo"SELECT * FROM step1 WHERE numero_du_patient='".$value."';";
			$query = $pdo->prepare("SELECT * FROM step1 WHERE numero_du_patient='".$value."';");
			$query->execute();
			$numrows = $query->fetch(PDO::FETCH_ASSOC);
			if($numrows==0){
				$query = "INSERT INTO step1 (numero_du_patient) VALUES ('".$value."');";
				echo $query;
				$pdo->exec($query);
			}
		}
	}else if($editplace == "saisie"){
		$infotable = $pdo->prepare('SHOW COLUMNS FROM step2;');
		$infotable->execute();
		$i = 0;
		while($infos = $infotable->fetch(PDO::FETCH_ASSOC)){
			preg_match('/[a-z]+/', $infos['Type'], $type);
			preg_match('/\d+/', $infos['Type'], $len);
			if(!isset($type[0]) || $type[0] == ""){
				$type[0] = "";
			}
			if(!isset($len[0]) || $len[0] == ""){
				$len[0] = "";
			}
			$coltype = $type[0];
			$charlength = $len[0];
			$i++;
		}
		if(!empty($charlength) && strlen($value) > $charlength){
			$type = preg_replace("/[^A-Za-z]/", "", $coltype);
			$len = $string = preg_replace("/[^0-9]/", "", $coltype);
			$datatype = datatype($value, $type, $len);
			$query = "ALTER TABLE step2 MODIFY ".$column." ".$datatype." (".strlen($value).");";
			echo $query;
			$pdo->exec($query);
		}
		if($row != "" && !empty($row)){
			$query = $pdo->prepare("SELECT * FROM step2 WHERE numero_du_patient='".$row."';");
			$query->execute();
			$numrows = $query->fetch(PDO::FETCH_ASSOC);
			if($numrows>=1){
				$query = "UPDATE step2 SET ".$column."='".$value."' WHERE numero_du_patient='".$row."';";
				echo $query;
				$pdo->exec($query);
			}
		}else if($row == "" || empty($row) && $column == "numero_du_patient"){
			$query = $pdo->prepare("SELECT * FROM step2 WHERE numero_du_patient='".$value."';");
			$query->execute();
			$numrows = $query->fetch(PDO::FETCH_ASSOC);
			if($numrows==0){
				$query = "INSERT INTO step2 (numero_du_patient) VALUES ('".$value."');";
				echo $query;
				$pdo->exec($query);
			}
		}
	}
	echo $value;
?>