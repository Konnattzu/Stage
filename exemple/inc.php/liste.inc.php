<?php
	if(defined("constante")){
		echo'
		<section>
			<article>
				<a href="index.php?ref=accueil">Retour à l&apos; accueil</a>
				<a href="index.php?ref=saisie">Nouvelle entrée</a>
				<h1>La liste</h1>';
				include("inc.php/parts/edit_data.inc.php");
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
						echo'<tr id="line'.$i.'">
							<form action="#line'.$i.'" method="post">';
					foreach ($row[$i] as $col => $val) {
						echo'<td class="dataline">';
							include("inc.php/parts/datalist.inc.php");
						echo'</td>';
						echo'
						<td class="editline">';
							include("inc.php/parts/editlist.inc.php");
							echo'</td>';
							
					}
						
					echo'<td class="editbtn">
							<label>
								<a href="#line'.$i.'">Edit</a>
							</label>
						</td>
						<td class="savebtn">
							<label>
								<input type="submit" name="save" value="Save">
							</label>
						</td>
						</form>
					</tr>';
					}else{
					echo'<tr name="tr" id="line'.$i.'">
							<form name="form" action="#line'.$i.'" method="post">';
					foreach ($row[$i] as $col => $val) {
						echo'<td class="dataline">';
							include("inc.php/parts/datalist.inc.php");
						echo'</td>';
						echo'
						<td class="editline">';
							include("inc.php/parts/editlist.inc.php");
							echo'</td>';
							
					}
						
					echo'<td class="editbtn">
							<label>
								<a href="#line'.$i.'">Edit</a>
							</label>
						</td>
						<td class="savebtn">
							<label>
								<input type="submit" name="save" value="Save">
							</label>
						</td>
						</form>
					</tr>';
					}
					$i++;
				}
				echo'</table>';
			echo'</article>
			<script type="text/javascript" src="js/edit.js"></script>
		</section>
		';
			}
	else die("");
?>
