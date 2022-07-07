<?php
$login = new Login($pdo);
echo $login->getHtml()['connexion'];
echo $login->getHtml()['inscription'];
$login->json_encode_private();
?>