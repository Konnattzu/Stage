<?php
		function clear($string){
			$string = strtr(utf8_decode($string), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
			$string = utf8_decode($string);
			$string = preg_replace("/[^A-Za-z0-9À-ú]/", "_", $string);
			$string = trim($string, "_");
			$string = strtolower($string);
			$string = utf8_encode($string);
			return $string;
		}
?>