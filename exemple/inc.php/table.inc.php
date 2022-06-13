<?php
	if(defined("constante")){
		echo'
		<section>
			<article>
				<a href="index.php?ref=liste">Voir les données</a>
				<a href="index.php?ref=accueil">Retour à l&apos; accueil</a>
				<h1>La liste</h1>';
				echo'<a id="savetable">Sauvegarder</a>';
		
		if(!isset($_SESSION["path"]) && !file_exists("documents/datafile.csv")) {
			$query = $pdo->prepare('SHOW TABLES LIKE "step2";');
			$query->execute();
			$numrows = $query->fetch(PDO::FETCH_ASSOC);
			if($numrows!=0){
				$req = $pdo->prepare('DROP TABLE step2;');
				$req->execute();
			}
		}
		if(file_exists("documents/datafile.csv")){
			$_SESSION["path"] = "documents/datafile.csv";
		}
		if(isset($_SESSION["path"]) && file_exists($_SESSION["path"])) {
			$csv = array_map("str_getcsv", file($_SESSION["path"]));
			if(isset($_SESSION["csv"]) && $csv != $_SESSION["csv"]){
				$req = $pdo->prepare('DROP TABLE step2;');
            	$req->execute();
			}
			$_SESSION["csv"] = $csv;
			$table = new Spreadsheet($csv, $pdo);
			// echo'<pre>';
			// print_r($table);
			// echo'</pre>';
			
			$query = $pdo->prepare('SHOW TABLES LIKE "step2";');
			$query->execute();
			$numrows = $query->fetch(PDO::FETCH_ASSOC);
			if($numrows==0){
				$table->createTable($pdo);
				$table->addData($csv, $pdo);
				echo'oui';
			}
		}
		$query = $pdo->prepare('SHOW TABLES LIKE "step2";');
		$query->execute();
		$numrows = $query->fetch(PDO::FETCH_ASSOC);
		if($numrows>=1){
			$col = 0;
			$row = 0;
			$header = array();
			$nbcol = array();
			$array = array();
			$datatype = array();
			$infotable = $pdo->prepare('SELECT * FROM INFORMATION_SCHEMA.COLUMNS where TABLE_NAME = "step2";');
			$infotable->execute();
			while($infos = $infotable->fetch(PDO::FETCH_ASSOC)){
				$header[$col] = $infos["COLUMN_NAME"];
				$charlength[$header[$col]] = $infos["CHARACTER_MAXIMUM_LENGTH"];
				$nbcol[$col] = $col;
				$datatype[$col] = $infos["DATA_TYPE"];
				$col++;
			}
			$query = $pdo->prepare('SELECT * FROM step2');
			$query->execute();
			while($data = $query->fetch(PDO::FETCH_ASSOC)){
				for($i=0;$i<count($header);$i++){
					$array[$i][$row] = $data[$header[$i]];
				}
				$row++;
			}
		}
		
		if(isset($array)){
		$color = array();
		echo'<script>
		function colortype(rows){
			color = Array();
			';
			for($i=0;$i<count($array);$i++){
				echo'
				color['.$i.'] = Array();';
				for($j=0;$j<count($array[$nbcol[$i]]);$j++){
					if(datatype($array[$nbcol[$i]][$j], "", 0) == "varchar"){
						$color[$nbcol[$i]][$j] = "red";
					}else if(datatype($array[$nbcol[$i]][$j], "", 0) == "int"){
						$color[$nbcol[$i]][$j] = "blue";
					}else if(datatype($array[$nbcol[$i]][$j], "", 0) == "date"){
						$color[$nbcol[$i]][$j] = "green";					
					}else{
						$color[$nbcol[$i]][$j] = "black";
					}
			echo'
					color['.$i.']['.$j.'] = "'.$color[$i][$j].'";
					if(typeof(rows['.$j.']) != "undefined" && typeof(rows['.$j.']['.$i.']) != "undefined"){
						rows['.$j.']['.$i.'].style.color = color['.$i.']['.$j.'];
					}
				';
				}
			}
			echo'}
			</script>';
		}
		include("inc.php/parts/grid.inc.php");
	}
	else die("");
?>
