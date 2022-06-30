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
	$column = clear($_POST["column"]);
	$value = $_POST["value"];
	$row = $_POST["row"];
	$editplace = $_POST["editplace"];
	if($editplace == "liste"){
		$bdtab = "step1";
	}else if($editplace == "saisie"){
		$bdtab = "step2";
	}
	$table = new BDDsheet($pdo, $bdtab);
	$table->sendData($column, $row, $value);
	echo $value;
?>