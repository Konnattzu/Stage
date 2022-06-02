<?php
	if(defined("constante")){
		echo'
		<section>
			<article>
				<a href="index.php?ref=accueil">Retour à l&apos; accueil</a>
				<a href="index.php?ref=saisie">Nouvelle entrée</a>
				<h1>La liste</h1>';
				include("inc.php/parts/datatype.func.php");
				include("inc.php/parts/clear.func.php");

		
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
			$datatype = Array();
			while($infos = $infotable->fetch_assoc()){
				$header[$col] = $infos["COLUMN_NAME"];
				$nbcol[$col] = $col;
				$datatype[$col] = $infos["DATA_TYPE"];
				$col++;
			}
			
			$req = mysqli_query($mysqli, "SELECT * FROM step1");
			while($data = $req->fetch_assoc()){
				for($i=0;$i<count($header);$i++){
					$array[$i][$row] = $data[$header[$i]];
				}
				$row++;
			}
			
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
			
			

			include("inc.php/parts/grid.inc.php");

			
			
	}
	else die("");
?>
