<?php
	if(defined("constante")){
		echo'
		<section>
			<article>
				<a href="index.php?ref=accueil">Retour à l&apos; accueil</a>
				<a href="index.php?ref=saisie">Nouvelle entrée</a>
				<h1>La liste</h1>';

			$table = new BDDsheet($pdo, "step1");
			// $table->createTable($pdo);
			
			for($j=0;$j<count($table->getHeader());$j++){
				$header[$j] = $table->getHeader()[$j]->getValue();
				for($i=0;$i<count($table->getRow());$i++){
					$array[$j][$i] = $table->getCell()[$j][$i]->getValue();
				}
			}
			
			$table->json_encode_private();
			// echo'<pre>';
			// print_r($table);
			// echo'</pre>';
			
			include("inc.php/parts/grid.inc.php");

			
			
	}
	else die("");
?>
