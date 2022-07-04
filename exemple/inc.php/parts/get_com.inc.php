<?php
    include("../../bddconnect.php");
    $rowid = $_POST["row"];
    $colid = $_POST["column"];
    $req = $pdo->prepare('SELECT * FROM commentaires WHERE identifiant="'.$rowid.'" AND colonne="'.$colid.'";');
    $req->execute();
    while($com = $req->fetch(PDO::FETCH_ASSOC)){
        echo $com["commentaire"];
    }
?>