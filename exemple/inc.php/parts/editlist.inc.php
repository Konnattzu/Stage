<?php

	if(defined("constante")){
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
						}else{
							echo'what';
						}
						
	}
	else die("");
						?>