<?php
	if(defined("constante")){
		echo'
		<section>
			<article>
				<a href="index.php?ref=accueil">Retour à l&apos; accueil</a>
				<a href="index.php?ref=saisie">Nouvelle entrée</a>
				<h1>La liste</h1>';

			$table = new BDDsheet();
			$table->createTable("step1");
			$infotable = $pdo->prepare('SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = "step2";');
			$infotable->execute();
			$col = 0;
			$row = 0;
			$datatype = Array();
			while($infos = $infotable->fetch(PDO::FETCH_ASSOC)){
				$header[$col] = $infos["COLUMN_NAME"];
				$nbcol[$col] = $col;
				$datatype[$col] = $infos["DATA_TYPE"];
				$col++;
				print_r($header);
			}
			$query = $pdo->prepare('SELECT * FROM step1');
			$query->execute();
			while($data = $query->fetch(PDO::FETCH_ASSOC)){
				for($i=0;$i<count($header);$i++){
					$array[$i][$row] = $data[$header[$i]];
				}
				$row++;
			}
			
			$color = Array();
			echo'<script>
			function colortype(rows){
				color = Array();
				';
				if(isset($array)){
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
				}
			echo'}
			</script>';
			
			

			include("inc.php/parts/grid.inc.php");

			
			
	}
	else die("");
?>
