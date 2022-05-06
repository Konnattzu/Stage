<?php
echo'[';
	if(isset($_GET) && isset($_GET["ref"]) && ($_GET["ref"] != "")) {
			$editplace = $_GET["ref"];
	if($editplace == "liste"){
		
		$infotable = mysqli_query($mysqli, 'SELECT 
									TABLE_CATALOG,
									TABLE_SCHEMA,
									TABLE_NAME, 
									COLUMN_NAME, 
									DATA_TYPE, 
									COLUMN_TYPE 
									FROM INFORMATION_SCHEMA.COLUMNS
									where TABLE_NAME = "step1";');
			$col = 0;
			$row = 0;
			while($infos = $infotable->fetch_assoc()){
				$header[$col] = $infos["COLUMN_NAME"];
				$nbcol[$col] = $col;
				$col++;
			}
			
			$req = mysqli_query($mysqli, "SELECT * FROM step1");
			while($data = $req->fetch_assoc()){
				for($i=0;$i<count($header);$i++){
					$array[$i][$row] = $data[$header[$i]];
				}
				$row++;
			}
		
	}else if($editplace == "saisie"){
		
		$infotable = mysqli_query($mysqli, 'SELECT 
									TABLE_CATALOG,
									TABLE_SCHEMA,
									TABLE_NAME, 
									COLUMN_NAME, 
									DATA_TYPE, 
									COLUMN_TYPE, 
									CHARACTER_MAXIMUM_LENGTH
									FROM INFORMATION_SCHEMA.COLUMNS
									where TABLE_NAME = "step2";');
			$col = 0;
			$row = 0;
			$header = array();
			$nbcol = array();
			$array = array();
			while($infos = $infotable->fetch_assoc()){
				$header[$col] = $infos["COLUMN_NAME"];
				$charlength[$header[$col]] = $infos["CHARACTER_MAXIMUM_LENGTH"];
				$nbcol[$col] = $col;
				$col++;
			}
			
			$req = mysqli_query($mysqli, "SELECT * FROM step2");
			while($data = $req->fetch_assoc()){
				for($i=0;$i<count($header);$i++){
					$array[$i][$row] = $data[$header[$i]];
				}
				$row++;
			}
		
	}
	}
	
	for($j=0;$j<$row-1;$j++){
			echo'{ ';
			for($i=0;$i<count($header)-1;$i++){
					echo '"'.$header[$i].'": "'.$array[$nbcol[$i]][$j].'", 
					';
			}
			echo '"'.$header[$i].'": "'.$array[$nbcol[$i]][$j].'"
			';
			echo'},';
		}
		echo '{ ';
		for($i=0;$i<count($header)-1;$i++){
				echo '"'.$header[$i].'": "'.$array[$nbcol[$i]][$j].'", 
				';
		}
		echo '"'.$header[$i].'": "'.$array[$nbcol[$i]][$j].'"
		';
		echo'}';
	
    echo'
	];';
?>