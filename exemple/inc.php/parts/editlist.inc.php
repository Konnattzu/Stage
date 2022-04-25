<?php

	if(defined("constante")){
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
					if(is_string($val)){
					if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$val))
					{
						$date = strtotime($val);
						$val = date("d/m/Y", $date);
					}
				}
				echo $val;
				echo'</td>';
				echo'
				<td class="editline">';
					if(preg_match("/[0-9]{2}\/[0-9]{2}\/[0-9]{4}/",$val) && date($val)) 
					{
						$date = DateTime::createFromFormat('d/m/Y', $val);
						$val = $date->format('Y-m-d');
						echo 'date<input type="date" name="'.$col.'" value="'.$val.'">';
					}else{
						echo 'numb<input type="numb" name="'.$col.'" value="'.$val.'">';
					}
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
						if(is_string($val)){
						if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$val))
						{
							$date = strtotime($val);
							$val = date("d/m/Y", $date);
						}
					}
					echo $val;
					echo'</td>';
					echo'
					<td class="editline">';
						if(!intval($val)){
						echo 'text<input type="text" name="'.$col.'" value="'.$val.'">';
					}else if(intval($val)){
						if(preg_match("/[0-9]{2}\/[0-9]{2}\/[0-9]{4}/",$val) && date($val)) 
						{
							$date = DateTime::createFromFormat('d/m/Y', $val);
							$val = $date->format('Y-m-d');
							echo 'date<input type="date" name="'.$col.'" value="'.$val.'">';
						}else{
							echo 'numb<input type="numb" name="'.$col.'" value="'.$val.'">';
						}
					}
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
	</section>';
						
						
	}
	else die("");
						?>