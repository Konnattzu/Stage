<?php
	include("../../bddconnect.php");
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $pass = $_POST['pass'];
    if(empty($nom)){
        echo "Le champ nom est vide.";
    }else if(empty($prenom)){
        echo "Le champ prénom est vide.";
    }else if(empty($pass)){
        echo "Le champ Mot de passe est vide.";
    }else{
        $pass = md5($pass);
        $query = $pdo->prepare("SELECT * FROM users WHERE nom = '".$nom."' AND prenom = '".$prenom."' AND pass = '".$pass."';");
        $query->execute();
        $numrows = $query->fetch(PDO::FETCH_ASSOC);
        if($numrows>=1){
            $usernom = $numrows['nom'];
            $userprenom = $numrows['prenom'];
            $userpass = $numrows['pass'];
            $userid = $numrows['user_id'];
            if($usernom == $nom && $userprenom == $prenom){
                if($userpass == $pass){
                    $_SESSION['user_id'] = $userid;
                    echo $userid;
                } else {
                    echo "Le mot de passe est incorrect";
                }
            }else{
				echo "Le compte n'a pas été trouvé.";
            }
        }else{
            echo "Le compte n'a pas été trouvé.";
        }
    } 
?>