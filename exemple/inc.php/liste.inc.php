<?php
	if(defined("constante")){
		echo'
		<section>
			<article>
				<a href="index.php?ref=accueil">Retour à l&apos; accueil</a>
				<a href="index.php?ref=saisie">Nouvelle entrée</a>
				<h1>La liste</h1>';

			$table = new BDDsheet($pdo);
			$table->createTable($pdo);
			
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
