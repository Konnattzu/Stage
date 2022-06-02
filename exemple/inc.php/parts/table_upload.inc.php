<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
				if (isset($_FILES['table']) AND $_FILES['table']['error'] == 0){
					if ($_FILES['table']['size'] <= 20000000){
					   $infosfichier = pathinfo($_FILES['table']['name']);
					   $extension_upload = $infosfichier['extension'];
					   $extensions_autorisees = 'csv';
					   if ($extension_upload == $extensions_autorisees){ 
						$_SESSION["path"] = "../../documents/datafile.csv";
						if(file_exists($_SESSION["path"])){
						   unlink($_SESSION["path"]);
						}
//print_r($_FILES['table']);
						   move_uploaded_file($_FILES['table']['tmp_name'],$_SESSION["path"]);
							$_SESSION["path"] = "documents/datafile.csv";
							echo $_SESSION["path"];
						}
					}
				}
?>
