<?php

	if(defined("constante")){
						if(is_string($val)){
							if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$val))
							{
								$date = strtotime($val);
								$val = date("d/m/Y", $date);
							}
						}
						echo $val;
						
	}
	else die("");//bonjour
						?>