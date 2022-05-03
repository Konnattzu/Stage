<?php
				if (isset($_FILES['table']) AND $_FILES['table']['error'] == 0){
					if ($_FILES['table']['size'] <= 20000000){
					   $infosfichier = pathinfo($_FILES['table']['name']);
					   $extension_upload = $infosfichier['extension'];
					   $extensions_autorisees = 'csv';
					   if ($extension_upload == $extensions_autorisees){ 
						$_SESSION["path"] = "documents/datafile.csv";
						   move_uploaded_file($_FILES['table']['tmp_name'],$_SESSION["path"]);
							$_SESSION["path"] .= $_FILES['table']['name'];
						   echo "Les changements on été sauvegardés !";
						}
					}
				}
?>