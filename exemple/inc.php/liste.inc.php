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
			$table->export_data_to_csv();
			// echo'<pre>';
			// print_r($table);
			// echo'</pre>';
			echo'
			<button id="kaplanbtn">kaplan</button>
			<button id="sankeybtn">sankey</button>
			';
			$graph = new Graph();
			// echo $graph->html["kaplan"];
			// echo $graph->html["sankey"];
			$graph->json_encode_private();
			echo'
			<script>
				console.log(graphObj);
				console.log(graphObj.html.sankey);
				console.log(graphObj.html.kaplan);
				kaplanbtn = document.getElementById("kaplanbtn");
				kaplanbtn.addEventListener("click", function(){
					console.log(graphObj);
					graphObj.setType("kaplan");
					graphObj.newGraph();
				}, false);
				sankeybtn = document.getElementById("sankeybtn");
				sankeybtn.addEventListener("click", function(){
					console.log(graphObj);
					graphObj.setType("sankey");
					graphObj.newGraph();
				}, false);
			</script>
			';
			include("inc.php/parts/grid.inc.php");

			
			
	}
	else die("");
?>
