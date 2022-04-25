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
				$path="documents/";
				include("inc.php/parts/table_upload.inc.php");
				echo'<form action="" method="post" enctype="multipart/form-data">
								<label class="file_input">
									<input type="file" name="table">
								</label>
								<input type="submit" name="send" value="Envoyer">
					</form>';
				
		//include("inc.php/parts/editlist.inc.php");
		
		if(isset($path)){
			$csv = array_map("str_getcsv", file($path)); 
			$header = array_shift($csv);
			echo'<section>';
				echo'<table>';
					echo'<tr class="colname">';
					for($j=0;$j<count($header);$j++){
						echo'<td>';
							echo $header[$j];			
						echo'</td>';
					$nbcol[$j] = array_search($header[$j], $header, true); 
					}
					echo'</tr>';
					$row=0;
					 foreach ($csv as $col) {
						for($j=0;$j<count($header);$j++){
							$array[$nbcol[$j]][$row] = $col[$nbcol[$j]];
						}
						$row++;
					}
					for($j=0;$j<$row;$j++){
						echo'<tr>';
							for($i=0;$i<count($header);$i++){
								echo'<td>';
									echo $array[$nbcol[$i]][$j];
								echo'</td>';
							}
						echo'</tr>';
					}
						
				echo'</table>';
			echo'</section>';
			include("inc.php/parts/create_table.inc.php");
			include("inc.php/parts/add_data.inc.php");
		}
	}
	else die("");
?>
