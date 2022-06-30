<?php
	$pdo = new PDO('mysql:host=localhost;dbname=exemple','root','bagnoletmmi76');
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	$pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
?>
