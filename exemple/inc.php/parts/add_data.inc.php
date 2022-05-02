<?php
	if(defined("constante")){
		$infotable = mysqli_query($_SESSION["mysqli"], 'SELECT 
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
			while($infos = $infotable->fetch_assoc()){
				$column[$i] = $infos["COLUMN_NAME"];
				$coltype[$i] = $infos["COLUMN_TYPE"];
				$charlength[$column[$i]] = $infos["CHARACTER_MAXIMUM_LENGTH"];
				$i++;
			}
		for($j=0;$j<$row;$j++){
			for($i=0;$i<count($header);$i++){
				$type[$i] = preg_replace("/[^A-Za-z]/", "", $coltype[$i]);
				$len[$i] = $string = preg_replace("/[^0-9]/", "", $coltype[$i]);
				$datatype = datatype($array[$nbcol[$i]][$j], $type[$i], $len[$i]);
				$datalength = datalength($array[$nbcol[$i]][$j], $len[$i]);
				if($datatype != $type[$i] || $datalength != $len[$i] || similar_text($header[$i], $column[$i])<8){
					
					for($k=0;$k<count($column);$k++){
						if($datatype == $type[$i] && $datalength == $len[$i] && similar_text($header[$i], $column[$k])>=8){
							$header[$i] = $column[$k];
						}
					}
				}
			}
			
			
			$querydata[$j] = "INSERT INTO step2 (";
			for($i=0;$i<count($header);$i++){
				$querydata[$j] .= $column[$i].", ";
			}
			$querydata[$j][strlen($querydata[$j])-2] = " ";
			$querydata[$j][strlen($querydata[$j])-1] = " ";
			$querydata[$j] = rtrim($querydata[$j]);
			$querydata[$j] .= ") VALUES (";
			for($i=0;$i<count($header);$i++){
				$querydata[$j] .= "'".$array[$nbcol[$i]][$j]."', ";	
			}
			$querydata[$j] .= ");";
			for($i=1;$i<=3;$i++){
				$querydata[$j][strlen($querydata[$j])-$i] = " ";
			}
			$querydata[$j][strlen($querydata[$j])-3] = ";";
			$querydata[$j][strlen($querydata[$j])-4] = ")";
			
			$queryupdate[$j] = "UPDATE step2 SET ";
			for($i=0;$i<count($header);$i++){
				$queryupdate[$j] .= $column[$i]."=";
				$queryupdate[$j] .= "'".$array[$nbcol[$i]][$j]."', ";
				if(!empty($charlength[$column[$i]]) && strlen($array[$nbcol[$i]][$j]) > $charlength[$column[$i]]){
					$type[$i] = preg_replace("/[^A-Za-z]/", "", $coltype[$i]);
					$len[$i] = $string = preg_replace("/[^0-9]/", "", $coltype[$i]);
					$datatype = datatype($array[$nbcol[$i]][$j], $type[$i], $len[$i]);
					mysqli_query($mysqli, "ALTER TABLE step2 MODIFY ".$column[$i]." ".$datatype." (".strlen($array[$nbcol[$i]][$j]).");");
				}
			}
			$queryupdate[$j][strlen($queryupdate[$j])-2] = " ";
			$queryupdate[$j][strlen($queryupdate[$j])-1] = " ";
			$queryupdate[$j] = rtrim($queryupdate[$j]);
			$identifier = $header[0];
			$idvalue = $array[$nbcol[0]][$j];
			$simi = similar_text($header[0], $column[0]);
			for($i=0;$i<count($header);$i++){
				if(similar_text($header[$i], $column[0] > $simi)){
					$simi = similar_text($header[$i], $column[0]);
					$identifier = $header[$i];
					$idvalue = $array[$nbcol[$i]][$j];
				}
			}
			$queryupdate[$j] .= " WHERE ".$column[$j]."='".$idvalue."';";
			mysqli_query($mysqli, $querydata[$j]);
		}
	}
	else die("");
						?>