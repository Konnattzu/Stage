<?php

	include("../../bddconnect.php");
	include("clear.func.php");
	include("datatype.func.php");
	
	//get datalist
	//get headers list
	//for each id, verify if it exists
	//if yes, update
	//else, insert
	//for each data
	//find the more approaching column name in the db
	//verify if type correspond with the column 
	//verify if charlen correspond with the column 
	//if not, increase column charlen
	//send data on the right column name
	
	$infotable1 = mysqli_query($mysqli, 'SELECT 
										TABLE_CATALOG,
										TABLE_SCHEMA,
										TABLE_NAME, 
										COLUMN_NAME, 
										DATA_TYPE, 
										COLUMN_TYPE, 
										CHARACTER_MAXIMUM_LENGTH
										FROM INFORMATION_SCHEMA.COLUMNS
										where TABLE_NAME = "step1";');
	$i = 0;
	$col1 = 0;
	$row1 = 0;
	while($infos1 = $infotable1->fetch_assoc()){
		$column1[$col1] = $infos1["COLUMN_NAME"];
		$coltype1[$col1] = $infos1["COLUMN_TYPE"];
		$charlength1[$column1[$col1]] = $infos1["CHARACTER_MAXIMUM_LENGTH"];
		$col1++;
	}
	
	$req1 = mysqli_query($mysqli, "SELECT * FROM step1");
	while($data1 = $req1->fetch_assoc()){
		for($i=0;$i<count($column1);$i++){
			$array1[$i][$row1] = $data1[$column1[$i]];
		}
		$row1++;
	}
	
	$infotable2 = mysqli_query($mysqli, 'SELECT 
										TABLE_CATALOG,
										TABLE_SCHEMA,
										TABLE_NAME, 
										COLUMN_NAME, 
										DATA_TYPE, 
										COLUMN_TYPE, 
										CHARACTER_MAXIMUM_LENGTH
										FROM INFORMATION_SCHEMA.COLUMNS
										where TABLE_NAME = "step2";');
	$i = 0;
	$col2 = 0;
	$row2 = 0;
	$column2 = array();
	$array2 = array();
	while($infos2 = $infotable2->fetch_assoc()){
		$column2[$col2] = $infos2["COLUMN_NAME"];
		$coltype2[$col2] = $infos2["COLUMN_TYPE"];
		$charlength2[$column2[$col2]] = $infos2["CHARACTER_MAXIMUM_LENGTH"];
		$col2++;
	}
	
	$req2 = mysqli_query($mysqli, "SELECT * FROM step2");
	while($data2 = $req2->fetch_assoc()){
		for($i=0;$i<count($column2);$i++){
			$array2[$i][$row2] = $data2[$column2[$i]];
		}
		$row2++;
	}
	
	
		if(count($column2) > count($column1)){
			for($i=count($column1);$i<count($column2);$i++){
				$type = preg_replace("/[^A-Za-z]/", "", $coltype2[$i]);
				$len = preg_replace("/[^0-9]/", "", $coltype2[$i]);
				echo "ALTER TABLE step1 ADD ".$column2[$i]." ".$type." (".$len.");";
				mysqli_query($mysqli, "ALTER TABLE step1 ADD ".$column2[$i]." ".$type." (".$len.");");
			}
		}
		for($i=0;$i<count($column2);$i++){
			if(!empty($charlength2[$column2[$i]]) && $charlength2[$column2[$i]] > $charlength1[$column1[$i]]){
				echo $array2[$i][0].'trop long';
				$type = preg_replace("/[^A-Za-z]/", "", $coltype2[$i]);
				$len = preg_replace("/[^0-9]/", "", $coltype2[$i]);
				echo "ALTER TABLE step1 MODIFY ".$column2[$i]." ".$type." (".$len.");";
				mysqli_query($mysqli, "ALTER TABLE step1 MODIFY ".$column2[$i]." ".$type." (".$len.");");
			}
		}
		
		$infotable1 = mysqli_query($mysqli, 'SELECT 
										TABLE_CATALOG,
										TABLE_SCHEMA,
										TABLE_NAME, 
										COLUMN_NAME, 
										DATA_TYPE, 
										COLUMN_TYPE, 
										CHARACTER_MAXIMUM_LENGTH
										FROM INFORMATION_SCHEMA.COLUMNS
										where TABLE_NAME = "step1";');
		$i = 0;
		$col1 = 0;
		$row1 = 0;
		$column1 = array();
		$nbcol1 = array();
		$array1 = array();
		while($infos1 = $infotable1->fetch_assoc()){
			$column1[$col1] = $infos1["COLUMN_NAME"];
			$coltype1[$col1] = $infos1["COLUMN_TYPE"];
			$charlength1[$column1[$col1]] = $infos1["CHARACTER_MAXIMUM_LENGTH"];
			$col1++;
		}
		
		$req1 = mysqli_query($mysqli, "SELECT * FROM step1");
		while($data1 = $req1->fetch_assoc()){
			for($i=0;$i<count($column1);$i++){
				$array1[$i][$row1] = $data1[$column1[$i]];
			}
			$row1++;
		}	
		
		for($i=0;$i<count($array2[0]);$i++){
			if(isset($array1[0][$i])){
				if(mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM step1 WHERE ".$column2[0]."='".$array2[0][$i]."';"))>=1){
					for($j=0;$j<count($column2);$j++){
						echo'case 1
						';
						echo"UPDATE step1 SET ".$column2[$j]."='".$array2[$j][$i]."' WHERE ".$column2[0]."='".$array2[0][$i]."';
						";
						mysqli_query($mysqli, "UPDATE step1 SET ".$column2[$j]."='".$array2[$j][$i]."' WHERE ".$column2[0]."='".$array2[0][$i]."';");
					}
				}else{
								echo'case 2
								';
					echo 'INSERT INTO step1 ('.$column2[0].') VALUES ("'.$array2[0][$i].'");
					';
					mysqli_query($mysqli, 'INSERT INTO step1 ('.$column2[0].') VALUES ("'.$array2[0][$i].'");');
					for($j=1;$j<count($column2);$j++){
						echo"UPDATE step1 SET ".$column2[$j]."='".$array2[$j][$i]."' WHERE ".$column2[0]."='".$array2[0][$i]."';
							";
							mysqli_query($mysqli, "UPDATE step1 SET ".$column2[$j]."='".$array2[$j][$i]."' WHERE ".$column2[0]."='".$array2[0][$i]."';");
					}
				}
			}else if(isset($array1[0][$i]) && $array2[0][$i] != $array1[0][$i]){
				if(mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM step1 WHERE ".$column2[0]."='".$array2[0][$i]."';"))==0){
								echo'case 3
								';
					echo 'INSERT INTO step1 ('.$column2[0].') VALUES ("'.$array2[0][$i].'");
					';
					mysqli_query($mysqli, 'INSERT INTO step1 ('.$column2[0].') VALUES ("'.$array2[0][$i].'");');
					for($j=1;$j<count($column2);$j++){
						echo"UPDATE step1 SET ".$column2[$j]."='".$array2[$j][$i]."' WHERE ".$column2[0]."='".$array2[0][$i]."';
							";
							mysqli_query($mysqli, "UPDATE step1 SET ".$column2[$j]."='".$array2[$j][$i]."' WHERE ".$column2[0]."='".$array2[0][$i]."';");
					}		
				}else{
					for($j=0;$j<count($column2);$j++){
						echo'case 4
						';
						echo"UPDATE step1 SET ".$column2[$j]."='".$array2[$j][$i]."' WHERE ".$column2[0]."='".$array2[0][$i]."';
						";
						mysqli_query($mysqli, "UPDATE step1 SET ".$column2[$j]."='".$array2[$j][$i]."' WHERE ".$column2[0]."='".$array2[0][$i]."';");
					}
				}
			}else{
				echo'case 5
						';
					echo 'INSERT INTO step1 ('.$column2[0].') VALUES ("'.$array2[0][$i].'");
					';
					mysqli_query($mysqli, 'INSERT INTO step1 ('.$column2[0].') VALUES ("'.$array2[0][$i].'");');
				for($j=1;$j<count($column2);$j++){
					echo"UPDATE step1 SET ".$column2[$j]."='".$array2[$j][$i]."' WHERE ".$column2[0]."='".$array2[0][$i]."';
						";
						mysqli_query($mysqli, "UPDATE step1 SET ".$column2[$j]."='".$array2[$j][$i]."' WHERE ".$column2[0]."='".$array2[0][$i]."';");
				}
			}
		}
	echo'oui';
?>