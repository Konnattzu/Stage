<?php
		function datalength($data, $datatype, $datalength){
			if($datatype == "int"){
				$datalength = 11;
			}else if($datatype == "varchar" && $datalength<strlen($data)){
				$datalength = strlen($data);
			}else if($datatype == "date"){
				if(preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$data) && date($data) && $datatype != "int(" && $datatype != "varchar"){
					$datalength = "Y-m-d";
				}else if(preg_match("/[0-9]{2}-[0-9]{2}-[0-9]{2}/",$data) && date($data) && $datatype != "int(" && $datatype != "varchar"){
					$datalength = "y/m/d";
				}else if(preg_match("#[0-9]{4}/[0-9]{2}/[0-9]{2}#",$data) && date($data) && $datatype != "int(" && $datatype != "varchar"){
					$datalength = "Y/m/d";
				}else if(preg_match("#[0-9]{2}/[0-9]{2}/[0-9]{2}#",$data) && date($data) && $datatype != "int(" && $datatype != "varchar"){
					$datalength = "d/m/y";
				}else if(preg_match("#[0-9]{2}/[0-9]{2}/[0-9]{4}#",$data) && date($data) && $datatype != "int(" && $datatype != "varchar"){
					$datalength = "d/m/Y";
				}
			}
			return $datalength;
		}
		function datatype($data, $datatype){
			if($data != ""){
				//print_r($data);
				if(((substr($data, 0, 3) == "oui") || (substr($data, 0, 3) == "non")) || ((substr($data, strlen($data)-3, 3) == "oui") || (substr($data, strlen($data)-3, 3) == "non")) || (preg_match("/^(0|1)$/", $data) && $datatype != "int")){
					$datatype = "boolean";
				}else if(!intval($data)){
					$datatype = "varchar";
				}else if(intval($data) && $datatype != "varchar"){
					if(preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$data) && date($data) && $datatype != "int(" && $datatype != "varchar") 
					{
						$datatype = "date";
					}else if(preg_match("/[0-9]{2}-[0-9]{2}-[0-9]{2}/",$data) && date($data) && $datatype != "int(" && $datatype != "varchar"){
						$datatype = "date";
					}else if(preg_match("#[0-9]{4}/[0-9]{2}/[0-9]{2}#",$data) && date($data) && $datatype != "int(" && $datatype != "varchar"){
						$datatype = "date";
					}else if(preg_match("#[0-9]{2}/[0-9]{2}/[0-9]{2}#",$data) && date($data) && $datatype != "int(" && $datatype != "varchar"){
						$datatype = "date";
					}else if(preg_match("#[0-9]{2}/[0-9]{2}/[0-9]{4}#",$data) && date($data) && $datatype != "int(" && $datatype != "varchar"){
						$datatype = "date";
					}else if($datatype != "varchar"){
						$datatype = "int";
					}else{
						$datatype = "varchar";
					}
				}else{
					$datatype = "varchar";
				}
			}
			return $datatype;
			
		}
?>
