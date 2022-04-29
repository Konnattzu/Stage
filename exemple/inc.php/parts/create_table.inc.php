<?php
	if(defined("constante")){
		$querytable = "CREATE TABLE IF NOT EXISTS step1
			 (";
		for($i=0;$i<count($header);$i++){
			$datalength = 0;
			$datatype = "";
			$header[$i] = clear($header[$i]);
			$querytable .= $header[$i].' ';
			for($j=0;$j<$row;$j++){
				$datalength = datalength($array[$nbcol[$i]][$j], $datalength);
				$datatype = datatype($array[$nbcol[$i]][$j], $datatype, $datalength);
				if($datatype != "date"){
					$datatype .= "(";
				}
			}
			if(preg_match("/[(]/", $datatype)){
				$querytable .= $datatype.''.$datalength.'), ';
			}else{
				$querytable .= $datatype.', ';
			}
		}
		$querytable .= ');';
		for($i=1;$i<=3;$i++){
			$querytable[strlen($querytable)-$i] = " ";
		}
		$querytable[strlen($querytable)-3] = ";";
		$querytable[strlen($querytable)-4] = ")";
		mysqli_query($mysqli, $querytable);
		
		mysqli_query($mysqli, "CREATE TABLE IF NOT EXISTS step2 LIKE step1;");
	}
	else die("");
?>