<?php
	if(defined("constante")){
		echo'
		<section>
			<article>
				<a href="index.php?ref=accueil">Retour à l&apos; accueil</a>
				<a href="index.php?ref=saisie">Nouvelle entrée</a>
				<h1>La liste</h1>';
				include("inc.php/parts/edit_data.inc.php");
				include("inc.php/parts/datatype.func.php");
				include("inc.php/parts/clear.func.php");

		//include("inc.php/parts/editlist.inc.php");
			// echo'<section>';
				// echo'<table>';
					// echo'<tr class="colname">';
					// for($j=0;$j<count($header);$j++){
						// echo'<td>';
							// echo $header[$j];
						// echo'</td>';
					// $nbcol[$j] = array_search($header[$j], $header, true);
					// }
					// echo'</tr>';
					// $row=0;
					 // foreach ($csv as $col) {
						// for($j=0;$j<count($header);$j++){
							// $array[$nbcol[$j]][$row] = $col[$nbcol[$j]];
						// }
						// $row++;
					// }
					// for($j=0;$j<$row;$j++){
						// echo'<tr>';
							// for($i=0;$i<count($header);$i++){
								// echo'<td>';
									// echo $array[$nbcol[$i]][$j];
								// echo'</td>';
							// }
						// echo'</tr>';
					// }

				// echo'</table>';
			// echo'</section>';
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
			while($infos = $infotable->fetch_assoc()){
				$header[$col] = $infos["COLUMN_NAME"];
				$nbcol[$col] = $col;
				$col++;
			}
			
			$req = mysqli_query($mysqli, "SELECT * FROM step1");
			while($data = $req->fetch_assoc()){
				for($i=0;$i<count($header);$i++){
					$array[$i][$row] = $data[$header[$i]];
				}
				$row++;
			}
			
			
			
			

			include("inc.php/parts/grid.inc.php");

			
			
	}
	else die("");
?>
