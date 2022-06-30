<?php

	include("../../bddconnect.php");
	include("../func/clear.func.php");
	include("../func/datatype.func.php");
	include("../class/Spreadsheet.class.php");
	include("../class/BDDsheet.class.php");
	include("../class/Header.class.php");
	include("../class/Cell.class.php");
	include("../class/Identifier.class.php");
	include("../class/Row.class.php");
	include("../class/Column.class.php");
	include("../class/Comment.class.php");
	
	$table1 = new BDDsheet($pdo, "step1");
	$table2 = new BDDsheet($pdo, "step2");

		if(count($table2->getHeader()) > count($table1->getHeader())){
			for($i=count($table1->getHeader());$i<count($table2->getHeader());$i++){
				echo "ALTER TABLE ".$table1->getBdTab()." ADD ".$table2->getCol()[$i]->getHead()." ".$table2->getCol()[$i]->getType()." (".$table2->getCol()[$i]->getLen().");";
				$query = "ALTER TABLE ".$table1->getBdTab()." ADD ".$table2->getCol()[$i]->getHead()." ".$table2->getCol()[$i]->getType()." (".$table2->getCol()[$i]->getLen().");";
				$pdo->exec($query);
			}
		}
		for($i=0;$i<count($table2->getHeader());$i++){
			if(!empty($table2->getCol()[$i]->getLen()) && $table2->getCol()[$i]->getLen() > $table1->getCol()[$i]->getLen()){
				echo "ALTER TABLE ".$table1->getBdTab()." ADD ".$table2->getCol()[$i]->getHead()." ".$table2->getCol()[$i]->getType()." (".$table2->getCol()[$i]->getLen().");";
				$query = "ALTER TABLE ".$table1->getBdTab()." ADD ".$table2->getCol()[$i]->getHead()." ".$table2->getCol()[$i]->getType()." (".$table2->getCol()[$i]->getLen().");";
				$pdo->exec($query);
			}
		}
		
		$table1 = new BDDsheet($pdo, "step1");
		for($i=0;$i<count($table2->getId());$i++){
			echo'oui';
			print_r($table2->getId()[$i]);
			if(null !== $table2->getId()[$i]->getValue()->getValue()){
			for($j=0;$j<count($table2->getCol());$j++){
				echo $table2->getCell()[$j][$i]->getValue();
				echo $table2->getCol()[$j]->getType();
				echo $table2->getCell()[$j][$i]->getColid()."<br>";
					if($table2->getCell()[$j][$i]->getValue() == ""){
						switch($table2->getCol()[$j]->getType()){
							case "int":
								$table2->getCell()[$j][$i]->setValue(0);
							break;
							case "tinyint":
								$table2->getCell()[$j][$i]->setValue(0);
							break;
							case "date":
								$table2->getCell()[$j][$i]->setValue("0001-01-01");
							break;
							case "varchar":
								$table2->getCell()[$j][$i]->setValue("NULL");
							break;
							case "enum":
								$table2->getCell()[$j][$i]->setValue("NULL");
							break;
						}
					}else{
						switch($table2->getCol()[$j]->getType()){
							case "varchar":
								$table2->getCell()[$j][$i]->setValue("'".$table2->getCell()[$j][$i]->getValue()."'");
							break;
							case "enum":
								$table2->getCell()[$j][$i]->setValue("'".$table2->getCell()[$j][$i]->getValue()."'");
							break;
						}
					}
					switch($table2->getCol()[$j]->getType()){
						case "date":
							$table2->getCell()[$j][$i]->setValue("'".$table2->getCell()[$j][$i]->getValue()."'");
						break;
						case "tinyint":
							$table2->getCell()[$j][$i]->setValue("'".$table2->getCell()[$j][$i]->getValue()."'");
						break;
					}
				}
				if(null !== $table2->getCell() && null !== $table1->getCell() && null !== $table2->getCell()[0] && null !== $table1->getCell()[0]){
					if(null !== $table2->getCell()[0][$i]->getValue() && null !== $table1->getCell()[0][$i]->getValue()){
						echo $table2->getCell()[0][$i]->getValue();
						echo $table1->getCell()[0][$i]->getValue();
						if($table2->getCell()[0][$i]->getValue() == $table1->getCell()[0][$i]->getValue()){
							$query = $pdo->prepare("SELECT * FROM ".$table1->getBdTab()." WHERE ".$table2->getId()[$i]->getValue()->getColid()."=".$table2->getId()[$i]->getValue()->getRowid().";");
							$query->execute();
							$numrows = $query->fetch(PDO::FETCH_ASSOC);
							if($numrows>=1){
								for($j=0;$j<count($table2->getCol());$j++){
									echo"UPDATE ".$table1->getBdTab()." SET ".$table2->getCol()[$j]->getHead()."=".$table2->getCell()[$j][$i]->getValue()." WHERE ".$table2->getId()[$i]->getValue()->getColid()."=".$table2->getCell()[$j][$i]->getRowid().";
									";
									$query = "UPDATE ".$table1->getBdTab()." SET ".$table2->getCol()[$j]->getHead()."=".$table2->getCell()[$j][$i]->getValue()." WHERE ".$table2->getId()[$i]->getValue()->getColid()."=".$table2->getCell()[$j][$i]->getRowid().";";
									$pdo->exec($query);
								}
							}else{
								echo 'INSERT INTO '.$table1->getBdTab().' ('.$table2->getId()[$i]->getValue()->getColid().') VALUES ('.$table2->getId()[$i]->getValue()->getRowid().');
								';
								$query = 'INSERT INTO '.$table1->getBdTab().' ('.$table2->getId()[$i]->getValue()->getColid().') VALUES ('.$table2->getId()[$i]->getValue()->getRowid().');';
								$pdo->exec($query);
								for($j=1;$j<count($table2->getCol());$j++){
									echo"UPDATE ".$table1->getBdTab()." SET ".$table2->getCol()[$j]->getHead()."=".$table2->getCell()[$j][$i]->getValue()." WHERE ".$table2->getId()[$i]->getValue()->getColid()."=".$table2->getCell()[$j][$i]->getRowid().";
										";
										$query = "UPDATE ".$table1->getBdTab()." SET ".$table2->getCol()[$j]->getHead()."=".$table2->getCell()[$j][$i]->getValue()." WHERE ".$table2->getId()[$i]->getValue()->getColid()."=".$table2->getCell()[$j][$i]->getRowid().";";
										$pdo->exec($query);
								}
							}
						}else if($table2->getCell()[0][$i]->getValue() != $table1->getCell()[0][$i]->getValue()){
							$query = $pdo->prepare("SELECT * FROM ".$table1->getBdTab()." WHERE ".$table2->getId()[$i]->getValue()->getColid()."=".$table2->getId()[$i]->getValue()->getRowid().";");
							$query->execute();
							$numrows = $query->fetch(PDO::FETCH_ASSOC);
							if($numrows==0){
								echo 'INSERT INTO '.$table1->getBdTab().' ('.$table2->getId()[$i]->getValue()->getColid().') VALUES ('.$table2->getId()[$i]->getValue()->getRowid().');
								';
								$query = 'INSERT INTO '.$table1->getBdTab().' ('.$table2->getId()[$i]->getValue()->getColid().') VALUES ('.$table2->getId()[$i]->getValue()->getRowid().');';
								$pdo->exec($query);
								for($j=1;$j<count($table2->getCol());$j++){
									echo"UPDATE ".$table1->getBdTab()." SET ".$table2->getCol()[$j]->getHead()."=".$table2->getCell()[$j][$i]->getValue()." WHERE ".$table2->getId()[$i]->getValue()->getColid()."=".$table2->getCell()[$j][$i]->getRowid().";
										";
										$query = "UPDATE ".$table1->getBdTab()." SET ".$table2->getCol()[$j]->getHead()."=".$table2->getCell()[$j][$i]->getValue()." WHERE ".$table2->getId()[$i]->getValue()->getColid()."=".$table2->getCell()[$j][$i]->getRowid().";";
										$pdo->exec($query);
								}		
							}else{
								for($j=0;$j<count($table2->getCol());$j++){
									// echo $table2->getCell()[$j][$i]->getValue();
									// echo $table2->getCell()[$j][$i]->getType();
									echo $table2->getCol()[$j]->getHead();
									echo $table2->getCell()[$j][$i]->getValue();
									echo $table2->getCol()[$j]->getType();
									echo $table2->getId()[$i]->getValue()->getColid();
									echo $table2->getCell()[$j][$i]->getRowid();
									echo"UPDATE ".$table1->getBdTab()." SET ".$table2->getCol()[$j]->getHead()."=".$table2->getCell()[$j][$i]->getValue()." WHERE ".$table2->getId()[$i]->getValue()->getColid()."=".$table2->getCell()[$j][$i]->getRowid().";
									";
									$query = "UPDATE ".$table1->getBdTab()." SET ".$table2->getCol()[$j]->getHead()."=".$table2->getCell()[$j][$i]->getValue()." WHERE ".$table2->getId()[$i]->getValue()->getColid()."=".$table2->getCell()[$j][$i]->getRowid().";";
									$pdo->exec($query);
								}
							}
						}else{
								echo 'INSERT INTO '.$table1->getBdTab().' ('.$table2->getId()[$i]->getValue()->getColid().') VALUES ('.$table2->getId()[$i]->getValue()->getRowid().');
								';
								$query = 'INSERT INTO '.$table1->getBdTab().' ('.$table2->getId()[$i]->getValue()->getColid().') VALUES ('.$table2->getId()[$i]->getValue()->getRowid().');';
								$pdo->exec($query);
							for($j=1;$j<count($table2->getCol());$j++){
								echo"UPDATE ".$table1->getBdTab()." SET ".$table2->getCol()[$j]->getHead()."=".$table2->getCell()[$j][$i]->getValue()." WHERE ".$table2->getId()[$i]->getValue()->getColid()."=".$table2->getCell()[$j][$i]->getRowid().";
									";
									$query = "UPDATE ".$table1->getBdTab()." SET ".$table2->getCol()[$j]->getHead()."=".$table2->getCell()[$j][$i]->getValue()." WHERE ".$table2->getId()[$i]->getValue()->getColid()."=".$table2->getCell()[$j][$i]->getRowid().";";
									$pdo->exec($query);
							}
						}
					}
				}
			}
		}
	echo'oui';
?>