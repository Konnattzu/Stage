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
		
		echo'<section>';
		echo'<br>';
$csv = array_map("str_getcsv", file("../documents/patientstest.csv")); 
$header = array_shift($csv);
// Seperate the header from data
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
		$querytable = "CREATE TABLE step1
			 (";
		for($i=0;$i<count($header);$i++){
			$datalength = 0;
			$datatype = "";
			$header[$i] = clear($header[$i]);
			echo $header[$i];
			$querytable .= $header[$i].' ';
			for($j=0;$j<$row;$j++){
				//echo $array[$nbcol[$i]][$j].', ';
				$datalength = datalength($array[$nbcol[$i]][$j], $datalength);
				$datatype = datatype($array[$nbcol[$i]][$j], $datatype, $datalength);
			}
			if(preg_match("/[(]/", $datatype)){
				$querytable .= $datatype.''.$datalength.'), ';
			}else{
				$querytable .= $datatype.', ';
			}
			
		}
			$querytable .= ');';
			echo'<br>';
			for($i=1;$i<=3;$i++){
				$querytable[strlen($querytable)-$i] = " ";
			}
			$querytable[strlen($querytable)-3] = ";";
			$querytable[strlen($querytable)-4] = ")";
			echo $querytable;
			//mysqli_query($mysqli, $querytable);
			echo'<br>';
			for($j=0;$j<$row;$j++){
				$querydata[$j] = "INSERT INTO step1 (";
				for($i=0;$i<count($header);$i++){
					$querydata[$j] .= $header[$i].", ";
				}
				$querydata[$j] .= ") VALUES (";
				for($i=0;$i<count($header);$i++){
					$querydata[$j] .= "'".$array[$nbcol[$i]][$j]."', ";	
				}
				$querydata[$j] .= ");";
				for($i=1;$i<=3;$i++){
					$querydata[$j][strlen($querydata[$j])-$i] = " ";
				}
				$querydata[$j][strlen($querydata[$j])-3] = ";";
				$querydata[$j][strlen($querydata[$j])-4] = ")";
				echo $querydata[$j];
				//mysqli_query($mysqli, $querydata);
				echo'<br>';
			}
			
			}
	else die("");
?>
