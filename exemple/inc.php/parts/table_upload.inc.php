<?php
	if(defined("constante")){
				if (isset($_FILES['table']) AND $_FILES['table']['error'] == 0){
					if ($_FILES['table']['size'] <= 20000000){
					   $infosfichier = pathinfo($_FILES['table']['name']);
					   $extension_upload = $infosfichier['extension'];
					   $extensions_autorisees = 'csv';
					   if ($extension_upload == $extensions_autorisees){ 
						   $path .= $_FILES['table']['name'];
						   move_uploaded_file($_FILES['table']['tmp_name'],$path);
						   echo "Les changements on été sauvegardés !";
						}
					}
				}
	}
	else die("");
?>