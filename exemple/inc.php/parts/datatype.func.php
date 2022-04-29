<?php
		function datalength($data, $datalength){
			if(intval($data)){
				$datalength = 11;
			}else if($datalength<strlen($data)){
				$datalength = strlen($data);
			}
			return $datalength;
		}
		function datatype($data, $datatype, $datalength){
			
			if(!intval($data)){
				$datatype = "varchar";
			}else if(intval($data) && $datatype != "varchar"){
				if(preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$data) && date($data) && $datatype != "int(" && $datatype != "varchar(") 
				{
					$datatype = "date";
				}else if($datatype != "varchar"){
					$datatype = "int";
				}else{
					$datatype = "varchar";
				}
			}else{
				$datatype = "varchar";
			}
			return $datatype;
			
		}
?>