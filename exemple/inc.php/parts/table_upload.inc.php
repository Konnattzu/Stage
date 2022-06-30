<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
				if (isset($_FILES['table']) AND $_FILES['table']['error'] == 0){
					if ($_FILES['table']['size'] <= 20000000){
					   $infosfichier = pathinfo($_FILES['table']['name']);
					   $extension_upload = $infosfichier['extension'];
					   $extensions_autorisees = 'csv';
					   if($extension_upload == $extensions_autorisees){ 
							$_SESSION["path"] = "../../documents/datafile.csv";
							if(file_exists($_SESSION["path"])){
							unlink($_SESSION["path"]);
							}
							move_uploaded_file($_FILES['table']['tmp_name'],$_SESSION["path"]);
							$_SESSION["path"] = "documents/datafile.csv";
							echo $_SESSION["path"];
						}else if($extension_upload == "xlsx"){
							require_once '../PHPExcel/PHPExcel/IOFactory.php';
							$inFile = $_FILES['table']['tmp_name'];
							$objReader = PHPExcel_IOFactory::createReader('Excel2007');
							$objPHPExcel = $objReader->load($inFile);

							$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');    
							$objWriter->setPreCalculateFormulas(true);


							$index = 0;
							foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {

								$objPHPExcel->setActiveSheetIndex($index);

								$outFile = "datafile.csv";
								$objWriter->setSheetIndex($index);
								$highestRow = $worksheet->getHighestDataRow();
								$highestCol = $worksheet->getHighestDataColumn();
								$worksheet->setHighestRow($highestRow);
								$worksheet->setHighestColumn($highestCol);
								$objWriter->save($outFile);
								$index++;
							}
							print_r(array_map("str_getcsv", file($outFile)));
							$_SESSION["path"] = "../../documents/datafile.csv";
							if(file_exists($_SESSION["path"])){
								unlink($_SESSION["path"]);
							}
							rename($outFile, $_SESSION["path"]);
							$_SESSION["path"] = "documents/datafile.csv";
							echo $_SESSION["path"];
						}else if($extension_upload == "xls"){
							require_once '../PHPExcel/PHPExcel/IOFactory.php';
							$inFile = $_FILES['table']['tmp_name'];
							$objReader = PHPExcel_IOFactory::createReader('Excel5');
							$objPHPExcel = $objReader->load($inFile);

							$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');    
							$objWriter->setPreCalculateFormulas(true);

							$index = 0;
							foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {

								$objPHPExcel->setActiveSheetIndex($index);

								// write out each worksheet to it's name with CSV extension
								$outFile = "datafile.csv";
								$objWriter->setSheetIndex($index);
								$objWriter->save($outFile);
								$index++;
							}
							print_r(array_map("str_getcsv", file($outFile)));
							$_SESSION["path"] = "../../documents/datafile.csv";
							if(file_exists($_SESSION["path"])){
								unlink($_SESSION["path"]);
							}
							rename($outFile, $_SESSION["path"]);
							$_SESSION["path"] = "documents/datafile.csv";
							echo $_SESSION["path"];
						}
					}
				}
?>
