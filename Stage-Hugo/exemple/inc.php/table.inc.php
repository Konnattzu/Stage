<?php
	if(defined("constante")){
		echo'
		<section>
			<article>
				<a href="index.php?ref=liste">Voir les données</a>
				<a href="index.php?ref=accueil">Retour à l&apos; accueil</a>
				<h1>La liste</h1>';
				include("inc.php/parts/datatype.func.php");
				include("inc.php/parts/clear.func.php");
				echo'<a id="savetable">Sauvegarder</a>';
		
		if(!isset($_SESSION["path"]) && !file_exists("documents/datafile.csv")) {
			mysqli_query($_SESSION["mysqli"], "DROP TABLE step2;");
		}
		if(file_exists("documents/datafile.csv")){
			$_SESSION["path"] = "documents/datafile.csv";
		}
		if(isset($_SESSION["path"]) && file_exists($_SESSION["path"])) {
			$csv = array_map("str_getcsv", file($_SESSION["path"]));
			if(isset($_SESSION["csv"]) && $csv != $_SESSION["csv"]){
				mysqli_query($_SESSION["mysqli"], "DROP TABLE step2;");
			}
			$_SESSION["csv"] = $csv;
			$header = array_shift($csv);
			
			for($j=0;$j<count($header);$j++){
				$nbcol[$j] = array_search($header[$j], $header, true);
			}
			$row=0;
			foreach ($csv as $col) {
				for($j=0;$j<count($header);$j++){
					$array[$nbcol[$j]][$row] = $col[$nbcol[$j]];
				}
				$row++;
			}
			
			if(mysqli_num_rows(mysqli_query($mysqli, "SHOW TABLES LIKE 'step2';"))==0){
				include("inc.php/parts/create_table.inc.php");
				include("inc.php/parts/add_data.inc.php");
			}
		}
		
		if(mysqli_num_rows(mysqli_query($mysqli, "SHOW TABLES LIKE 'step2';"))>=1){
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
			$datatype = array();
			while($infos = $infotable->fetch_assoc()){
				$header[$col] = $infos["COLUMN_NAME"];
				$charlength[$header[$col]] = $infos["CHARACTER_MAXIMUM_LENGTH"];
				$nbcol[$col] = $col;
				$datatype[$col] = $infos["DATA_TYPE"];
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
