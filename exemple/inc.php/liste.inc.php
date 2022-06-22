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
			
			for($j=0;$j<count($table->getHeader());$j++){
				$header[$j] = $table->getHeader()[$j]->getValue();
				for($i=0;$i<count($table->getRow());$i++){
					$array[$j][$i] = $table->getCell()[$j][$i]->getValue();
				}
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
						for($j=0;$j<count($array[$i]);$j++){
							if(datatype($array[$i][$j], "", 0) == "varchar"){
								$color[$i][$j] = "red";
							}else if(datatype($array[$i][$j], "", 0) == "int"){
								$color[$i][$j] = "blue";
							}else if(datatype($array[$i][$j], "", 0) == "date"){
								$color[$i][$j] = "green";					
							}else{
								$color[$i][$j] = "black";
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
			$table->json_encode_private();
			
			

			include("inc.php/parts/grid.inc.php");

			
			
	}
	else die("");
?>
