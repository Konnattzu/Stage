<?php
		echo'
		<section>
			<article>
				<a href="index.php?ref=accueil">Retour à l&apos; accueil</a>
				<a href="index.php?ref=saisie">Nouvelle entrée</a>
				<h1>La liste</h1>';
				$liste = mysqli_query($_SESSION["mysqli"], 'SELECT * FROM patientstest;');
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
											where TABLE_NAME = "patientstest" 
											and COLUMN_NAME = "'.$col.'";');
						
						echo $col." (";
						while($desc = $infos->fetch_assoc()){
							echo $desc["TABLE_CATALOG"].", ";
							echo $desc["TABLE_SCHEMA"].", ";
							echo $desc["TABLE_NAME"].", ";
							echo $desc["COLUMN_NAME"].", ";
							echo $desc["DATA_TYPE"].")";
						};
							echo'</td>';
						}
						echo'</tr>';
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
											where TABLE_NAME = "patientstest" 
											and COLUMN_NAME = "'.$col.'";');
						if(is_string($val)){
							if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$val))
							{
								$date = strtotime($val);
								$val = date("d/m/Y", $date);
							}
						}
						echo $val;
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
											where TABLE_NAME = "patientstest" 
											and COLUMN_NAME = "'.$col.'";');
						
						if(is_string($val)){
							if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$val))
							{
								$date = strtotime($val);
								$val = date("d/m/Y", $date);
							}
						}
						echo $val;
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
