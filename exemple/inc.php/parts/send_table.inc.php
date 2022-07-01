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
	$table2->compareTablength($table1);
	$table1 = new BDDsheet($pdo, "step1");
	$table2->sendTable($table1);
?>