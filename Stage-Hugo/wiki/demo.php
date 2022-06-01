<?php

echo'<form action="" method="post" enctype="multipart/form-data">
	<input type="file" name="tableur">
</form>';

include('inc.php/upload_file.inc.php');

if(isset($_SESSION["path"]) && file_exists($_SESSION["path"])) {
	$csv = array_map("str_getcsv", file($_SESSION["path"]));
	$header = array_shift($csv);
	foreach ($csv as $rows) {
		$req = '"INSERT INTO table1 (';
		for($j=0;$j<count($header)-1;$j++){
			$req .= '"'.$column[$j].'", ';
		}
		$req .= '"'.$column[$j].'") VALUES (';
		for($j=0;$j<count($header);$j++){
			$value[$i][$j] = $rows[$j];
			$req .= '"'.$value[$i][$j].'", ';
		}
		$req .= '"'.$value[$i][$j].'");';
		mysqli_query($mysqli, $req);
	}
}

if(mysqli_num_rows(mysqli_query($mysqli, "SHOW TABLES LIKE 'table1';"))>=1){
	$infotable = mysqli_query($mysqli, 'SELECT 
							TABLE_CATALOG,
							TABLE_SCHEMA,
							TABLE_NAME, 
							COLUMN_NAME, 
							DATA_TYPE, 
							COLUMN_TYPE, 
							CHARACTER_MAXIMUM_LENGTH
							FROM INFORMATION_SCHEMA.COLUMNS
							where TABLE_NAME = "table1";');
	$col = 0;
	$row = 0;
	$header = array();
	$nbcol = array();
	$array = array();
	while($infos = $infotable->fetch_assoc()){
		$header[$col] = $infos["COLUMN_NAME"];
		$charlength[$header[$col]] = $infos["CHARACTER_MAXIMUM_LENGTH"];
		$col++;
	}
	
	$req = mysqli_query($mysqli, "SELECT * FROM table1");
	while($data = $req->fetch_assoc()){
		for($i=0;$i<count($header);$i++){
			$array[$i][$row] = $data[$header[$i]];
		}
		$row++;
	}
	
	echo'dataset = ';
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
}

?>