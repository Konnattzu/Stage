<?php
	if(defined("constante")){
		function clear($string){
			
			$string = preg_replace("/[^A-Za-z0-9À-ú]/", "_", $string);
			
			
			//$string = preg_replace("/\s/", "_", $string);
			//$string = strtr(utf8_decode($string), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
			// $string = str_replace(" ", "_", $string);
			
			// for($k=0;$k<strlen($string);$k++){
				// echo $k;
			// }
			//$string = strtolower($string);
			
			return $string;
		}
		
	}
	else die("");
?>