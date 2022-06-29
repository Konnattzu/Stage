<?php
echo'[';
	if(isset($_GET) && isset($_GET["ref"]) && ($_GET["ref"] != "")) {
		$editplace = $_GET["ref"];
		if($editplace == "liste"){
				$col = 0;
				$row = 0;
				$query = 'SELECT * FROM INFORMATION_SCHEMA.COLUMNS where TABLE_NAME = "step1";';
				$infotable = $pdo->query($query);
				while($infos = $infotable->fetch(PDO::FETCH_ASSOC)){
					$header[$col] = $infos["COLUMN_NAME"];
					$nbcol[$col] = $col;
					$col++;
				}
				
				$query = $pdo->prepare('SELECT * FROM step1');
				$query->execute();
				while($data = $query->fetch(PDO::FETCH_ASSOC)){
					for($i=0;$i<count($header);$i++){
						$array[$i][$row] = $data[$header[$i]];
					}
					$row++;
				}
		}else if($editplace == "saisie"){
			
			$col = 0;
			$row = 0;
			$header = array();
			$nbcol = array();
			$array = array();
			$query = 'SELECT * FROM INFORMATION_SCHEMA.COLUMNS where TABLE_NAME = "step2";';
			$infotable = $pdo->query($query);
			while($infos = $infotable->fetch(PDO::FETCH_ASSOC)){
				$header[$col] = $infos["COLUMN_NAME"];
				$charlength[$header[$col]] = $infos["CHARACTER_MAXIMUM_LENGTH"];
				$nbcol[$col] = $col;
				$col++;
			}
			
			$query = $pdo->prepare('SHOW TABLES LIKE "step2";');
			$query->execute();
			$numrows = $query->fetch(PDO::FETCH_ASSOC);
			if($numrows >= 1){
				$query = $pdo->prepare('SELECT * FROM step2');
				$query->execute();
				while($data = $query->fetch(PDO::FETCH_ASSOC)){
					for($i=0;$i<count($header);$i++){
						$array[$i][$row] = $data[$header[$i]];
					}
					$row++;
				}
			}
		}
	}
	if(isset($header) && isset($header[0]) && isset($array) && isset($array[0])){
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
		}';
	}
		echo']';

	
?>