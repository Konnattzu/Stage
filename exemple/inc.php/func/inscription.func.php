<?php
	include("../../bddconnect.php");
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $pass = $_POST['pass'];
    $confpass = $_POST['confpass'];
    $mail = trim($_POST['email']);
    $modlvl = $_POST['lvl'];
    if(empty($nom)){
        echo "Le champ nom est vide.";
    }else if(empty($prenom)){
        echo "Le champ prénom est vide.";
    }else if(!preg_match("#[a-zA-Z]#",$nom) || !preg_match("#[a-zA-Z]#",$prenom)){
        echo "Le nom et le prénom ne peuvent contenir que des lettres minuscules ou majuscules.";
    }else if(strlen($prenom)>32){
        echo "Le prénom est trop long, il dépasse 32 caractères.";
    }else if(strlen($nom)>32){
        echo "Le nom est trop long, il dépasse 32 caractères.";
    }else if(empty($pass)){
        echo "Le champ Mot de passe est vide.";
    }else if(strlen($pass)<7){
        echo "Le mot de passe est trop court, il doit contenir au moins 8 caractères.";
    }else if(isset($mail) && !preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix",$mail)){
        echo "L'adresse mail n'est pas valide.";
    }else{
        $query = $pdo->prepare("SELECT * FROM users WHERE nom='".$nom."' AND prenom='".$prenom."';");
        $query->execute();
        $numrows = $query->fetch(PDO::FETCH_ASSOC);
        if($numrows>=1){
            echo "Cet utilisateur existe déjà.";
        }else{
            $pass = md5($pass);
            $query = $pdo->prepare("INSERT INTO `images` (image_path) VALUES (default);");
            $query->execute();
            $req = $pdo->prepare('SELECT * FROM images ORDER BY image_id DESC LIMIT 1;');
            $req->execute();
            $image = $req->fetch(PDO::FETCH_ASSOC);
            $query = $pdo->prepare("INSERT INTO users SET nom='".$nom."', prenom='".$prenom."', pass='".$pass."', mail='".$mail."', modlvl='".$modlvl."', profil_img='".$image['image_id']."';");
            $query->execute();
            $req = $pdo->prepare('SELECT user_id FROM users ORDER BY user_id DESC LIMIT 1;');
            $req->execute();
            $id = $req;
            $_SESSION["user_id"] = $id->fetch(PDO::FETCH_NUM)[0];
            echo $_SESSION["user_id"];
        }
    } 
?>