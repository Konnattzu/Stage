<?php
	if(defined("constante")){
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
			include("inc.php/parts/grid.inc.php");
	}
	else die("");
?>
