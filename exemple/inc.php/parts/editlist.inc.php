<?php

	if(defined("constante")){
						if(!intval($val)){
							echo 'text<input type="text" name="'.$col.'" value="'.$val.'">';
						}else if(intval($val)){
							if(date($val)) 
							{
								$date = strtotime($val);
								$val = date("d/m/Y", $date);
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