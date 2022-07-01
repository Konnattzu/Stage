<?php
	$pdo = new PDO('mysql:host=localhost;dbname=zgak5693_umr978','zgak5693_umr978','inserm93000');
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	$pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
?>
