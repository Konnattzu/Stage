<?php
	if(defined("constante")){
		$querytable = "CREATE TABLE IF NOT EXISTS step1
			 (";
		for($i=0;$i<count($header);$i++){
			$datalength = 0;
			$datatype = "";
			$header[$i] = clear($header[$i]);
			if(!empty($header[$i])){
				$querytable .= $header[$i].' ';
			}else{
				$querytable .= 'colonne'.$i.' ';
			}
			$enum = Array();
			for($j=0;$j<$row;$j++){
				if($array[$nbcol[$i]][$j] != ""){
					$enum[count($enum)] = $array[$nbcol[$i]][$j];
					if(count($enum)>0){
						for($k=0;$k<count($enum)-1;$k++){
							if($enum[$k] == $array[$nbcol[$i]][$j]){
								unset($enum[count($enum)-1]);
							}
						}
					}
				}
				$datalength = datalength($array[$nbcol[$i]][$j], $datatype, $datalength);
				$datatype = datatype($array[$nbcol[$i]][$j], $datatype, $datalength);
				if(($datatype == "boolean") && ($array[$nbcol[$i]][$j] != "oui") && ($array[$nbcol[$i]][$j] != "non") && ($array[$nbcol[$i]][$j] != "1") && ($array[$nbcol[$i]][$j] != "0")){
					$comment = preg_replace("/(oui|non|1|0)/", " ", $array[$nbcol[$i]][$j]);
					$comment = trim($comment);
					$array[$nbcol[$i]][$j] == str_replace($comment, " ", $array[$nbcol[$i]][$j]);
					$array[$nbcol[$i]][$j] == trim($array[$nbcol[$i]][$j]);
				}
			}
			if(count($array[0])>16){
				if(count($enum)<8 && $datatype != "boolean"){
					$datatype = "enum";
					$datalength = "";
					for($k=0;$k<count($enum)-1;$k++){
						$datalength .= "'".$enum[$k]."', ";
					}
					$datalength .= "'".$enum[$k]."'";
				}
			}else{
				if(count($enum)<(count($array[0])*0.75) && $datatype != "boolean"){
					$datatype = "enum";
					$datalength = "";
					for($k=0;$k<count($enum)-1;$k++){
						$datalength .= "'".$enum[$k]."', ";
					}
					$datalength .= "'".$enum[$k]."'";
				}
			}
			if(($datatype != "date") && ($datatype != "boolean")){
				$datatype .= "(";
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