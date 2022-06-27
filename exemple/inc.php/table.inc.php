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
			
			$table->json_encode_private();
		}
		include("inc.php/parts/grid.inc.php");
	}
	else die("");
?>
