<?php

	include("../../bddconnect.php");
	include("../func/clear.func.php");
	include("../func/datatype.func.php");
	
	$infotable = $pdo->prepare('SHOW COLUMNS FROM step1;');
	$infotable->execute();
	$i = 0;
	$col1 = 0;
	$row1 = 0;
	while($infos1 = $infotable->fetch(PDO::FETCH_ASSOC)){
		preg_match('/[a-z]+/', $infos1['Type'], $type);
		preg_match('/\d+/', $infos1['Type'], $len);
		if(!isset($type[0]) || $type[0] == ""){
			$type[0] = "";
		}
		if(!isset($len[0]) || $len[0] == ""){
			$len[0] = "";
		}
		$column1[$col1] = $infos1["Field"];
		$coltype1[$col1] = $type[0];
		$charlength1[$column1[$col1]] = $len[0];
		$col1++;
	}
	
	$req = $pdo->prepare('SELECT * FROM step1;');
	$req->execute();
	while($data1 = $req->fetch(PDO::FETCH_ASSOC)){
		for($i=0;$i<count($column1);$i++){
			if($data1[$column1[$i]] == ""){
				$array1[$i][$row1] = "NULL";
			}else{
				$array1[$i][$row1] = "'".$data1[$column1[$i]]."'";
			}
		}
		$row1++;
	}
	
	$infotable = $pdo->prepare('SHOW COLUMNS FROM step2;');
	$infotable->execute();
	$i = 0;
	$col2 = 0;
	$row2 = 0;
	while($infos2 = $infotable->fetch(PDO::FETCH_ASSOC)){
		preg_match('/[a-z]+/', $infos2['Type'], $type);
		preg_match('/\d+/', $infos2['Type'], $len);
		if(!isset($type[0]) || $type[0] == ""){
			$type[0] = "";
		}
		if(!isset($len[0]) || $len[0] == ""){
			$len[0] = "";
		}
		$column2[$col2] = $infos2["Field"];
		$coltype2[$col2] = $type[0];
		$charlength2[$column2[$col2]] = $len[0];
		$col2++;
	}
	
	$req = $pdo->prepare('SELECT * FROM step2;');
	$req->execute();
	while($data2 = $req->fetch(PDO::FETCH_ASSOC)){
		for($i=0;$i<count($column2);$i++){
			if($data2[$column1[$i]] == ""){
				$array2[$i][$row2] = "NULL";
			}else{
				$array2[$i][$row2] = "'".$data2[$column2[$i]]."'";
			}
		}
		$row2++;
	}
	
	
		if(count($column2) > count($column1)){
			for($i=count($column1);$i<count($column2);$i++){
				$type = preg_replace("/[^A-Za-z]/", "", $coltype2[$i]);
				$len = preg_replace("/[^0-9]/", "", $coltype2[$i]);
				echo "ALTER TABLE step1 ADD ".$column2[$i]." ".$type." (".$len.");";
				$query = "ALTER TABLE step1 ADD ".$column2[$i]." ".$type." (".$len.");";
				$pdo->exec($query);
			}
		}
		for($i=0;$i<count($column2);$i++){
			if(!empty($charlength2[$column2[$i]]) && $charlength2[$column2[$i]] > $charlength1[$column1[$i]]){
				$type = preg_replace("/[^A-Za-z]/", "", $coltype2[$i]);
				$len = preg_replace("/[^0-9]/", "", $coltype2[$i]);
				echo "ALTER TABLE step1 MODIFY ".$column2[$i]." ".$type." (".$len.");";
				$query = "ALTER TABLE step1 MODIFY ".$column2[$i]." ".$type." (".$len.");";
				$pdo->exec($query);
			}
		}
		
		$infotable = $pdo->prepare('SHOW COLUMNS FROM step1;');
		$infotable->execute();
		$i = 0;
		$col1 = 0;
		$row1 = 0;
		$column1 = array();
		$nbcol1 = array();
		$array1 = array();
		while($infos1 = $infotable->fetch(PDO::FETCH_ASSOC)){
			preg_match('/[a-z]+/', $infos1['Type'], $type);
			preg_match('/\d+/', $infos1['Type'], $len);
			if(!isset($type[0]) || $type[0] == ""){
				$type[0] = "";
			}
			if(!isset($len[0]) || $len[0] == ""){
				$len[0] = "";
			}
			$column1[$col1] = $infos1["Field"];
			$coltype1[$col1] = $type[0];
			$charlength1[$column1[$col1]] = $len[0];
			$col1++;
		}
		
		$req = $pdo->prepare('SELECT * FROM step1;');
		$req->execute();
		while($data1 = $req->fetch(PDO::FETCH_ASSOC)){
			for($i=0;$i<count($column1);$i++){
				if($data1[$column1[$i]] == ""){
					$array1[$i][$row1] = "NULL";
				}else{
					$array1[$i][$row1] = "'".$data1[$column1[$i]]."'";
				}
			}
			$row1++;
		}	
		
		for($i=0;$i<count($array2[0]);$i++){
			if(isset($array1[0][$i]) && $array2[0][$i] == $array1[0][$i]){
				$query = $pdo->prepare("SELECT * FROM step1 WHERE ".$column2[0]."=".$array2[0][$i].";");
				$query->execute();
				$numrows = $query->fetch(PDO::FETCH_ASSOC);
				if($numrows>=1){
					for($j=0;$j<count($column2);$j++){
						echo"UPDATE step1 SET ".$column2[$j]."=".$array2[$j][$i]." WHERE ".$column2[0]."=".$array2[0][$i].";
						";
						$query = "UPDATE step1 SET ".$column2[$j]."=".$array2[$j][$i]." WHERE ".$column2[0]."=".$array2[0][$i].";";
						$pdo->exec($query);
					}
				}else{
					echo 'INSERT INTO step1 ('.$column2[0].') VALUES ('.$array2[0][$i].');
					';
					$query = 'INSERT INTO step1 ('.$column2[0].') VALUES ('.$array2[0][$i].');';
					$pdo->exec($query);
					for($j=1;$j<count($column2);$j++){
						echo"UPDATE step1 SET ".$column2[$j]."=".$array2[$j][$i]." WHERE ".$column2[0]."=".$array2[0][$i].";
							";
							$query = "UPDATE step1 SET ".$column2[$j]."=".$array2[$j][$i]." WHERE ".$column2[0]."=".$array2[0][$i].";";
							$pdo->exec($query);
					}
				}
			}else if(isset($array1[0][$i]) && $array2[0][$i] != $array1[0][$i]){
				$query = $pdo->prepare("SELECT * FROM step1 WHERE ".$column2[0]."=".$array2[0][$i].";");
				$query->execute();
				$numrows = $query->fetch(PDO::FETCH_ASSOC);
				if($numrows==0){
					echo 'INSERT INTO step1 ('.$column2[0].') VALUES ('.$array2[0][$i].');
					';
					$query = 'INSERT INTO step1 ('.$column2[0].') VALUES ('.$array2[0][$i].');';
					$pdo->exec($query);
					for($j=1;$j<count($column2);$j++){
						echo"UPDATE step1 SET ".$column2[$j]."=".$array2[$j][$i]." WHERE ".$column2[0]."=".$array2[0][$i].";
							";
							$query = "UPDATE step1 SET ".$column2[$j]."=".$array2[$j][$i]." WHERE ".$column2[0]."=".$array2[0][$i].";";
							$pdo->exec($query);
					}		
				}else{
					for($j=0;$j<count($column2);$j++){
						echo"UPDATE step1 SET ".$column2[$j]."=".$array2[$j][$i]." WHERE ".$column2[0]."=".$array2[0][$i].";
						";
						$query = "UPDATE step1 SET ".$column2[$j]."=".$array2[$j][$i]." WHERE ".$column2[0]."=".$array2[0][$i].";";
						$pdo->exec($query);
					}
				}
			}else{
					echo 'INSERT INTO step1 ('.$column2[0].') VALUES ('.$array2[0][$i].');
					';
					$query = 'INSERT INTO step1 ('.$column2[0].') VALUES ('.$array2[0][$i].');';
					$pdo->exec($query);
				for($j=1;$j<count($column2);$j++){
					echo"UPDATE step1 SET ".$column2[$j]."=".$array2[$j][$i]." WHERE ".$column2[0]."=".$array2[0][$i].";
						";
						$query = "UPDATE step1 SET ".$column2[$j]."=".$array2[$j][$i]." WHERE ".$column2[0]."=".$array2[0][$i].";";
						$pdo->exec($query);
				}
			}
		}
	echo'oui';
?>