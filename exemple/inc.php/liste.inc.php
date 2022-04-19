<?php
		echo'
		<section>
			<article>
				<a href="index.php?ref=liste">Retour à l&apos; accueil</a>
				<h1>La liste</h1>';
				$liste = mysqli_query($_SESSION["mysqli"], 'SELECT * FROM exemple;');
				$i = 0;
				echo'<table>';
				while($data = $liste->fetch_assoc()){
					$row[$i] = $data;
					if($i == 0){
						echo'<tr>';
						foreach ($row[$i] as $col => $val) {
							echo'<td class="colname">';
							$infos = mysqli_query($_SESSION["mysqli"], 'SELECT 
												TABLE_CATALOG,
												TABLE_SCHEMA,
												TABLE_NAME, 
												COLUMN_NAME, 
												DATA_TYPE 
												FROM INFORMATION_SCHEMA.COLUMNS
												where TABLE_NAME = "exemple" 
												and COLUMN_NAME = "'.$col.'";');
							
							echo $val." (";
							while($desc = $infos->fetch_assoc()){
								echo $desc["TABLE_CATALOG"].", ";
								echo $desc["TABLE_SCHEMA"].", ";
								echo $desc["TABLE_NAME"].", ";
								echo $desc["COLUMN_NAME"].", ";
								echo $desc["DATA_TYPE"].")";
							}
							echo'</td>';
						}
						echo'</tr>';
					}else{
					echo'<tr>';
					foreach ($row[$i] as $col => $val) {
							echo'<td>';
						$infos = mysqli_query($_SESSION["mysqli"], 'SELECT 
											TABLE_CATALOG,
											TABLE_SCHEMA,
											TABLE_NAME, 
											COLUMN_NAME, 
											DATA_TYPE 
											FROM INFORMATION_SCHEMA.COLUMNS
											where TABLE_NAME = "exemple" 
											and COLUMN_NAME = "'.$col.'";');
						
						echo $val." (";
						while($desc = $infos->fetch_assoc()){
							echo $desc["TABLE_CATALOG"].", ";
							echo $desc["TABLE_SCHEMA"].", ";
							echo $desc["TABLE_NAME"].", ";
							echo $desc["COLUMN_NAME"].", ";
							echo $desc["DATA_TYPE"].")";
						}
						echo'</td>';
					}
						
					echo'</tr>';
					}
					
					
					$i++;
				}
				echo'</table>';
			echo'</article>
		</section>
		';
?>
