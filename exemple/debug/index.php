<?php
// l'utilisation d'une constante permet de spécifier le fichier de log à un seul endroit

define('DEBUG_LOG_FILE', './log/log_exemple.log');

// ... du code

// veut loguer le message $msg dans le fichier
// 3 est le niveau de debug

// Le format :
// - La date
// - Le nom du fichier
// - Le message

$msg="\n".date('Y-m-d H:i:s')."\t".$_SERVER['PHP_SELF']."\t"."Mon Super message";

// extrait de la doc php
//  message
// 
//     Le message d'erreur qui doit être stocké.
// message_type
// 
//     Spécifie la destination du message d'erreur. Les types possibles de messages sont :
//     error_log() log types 0 message est envoyé à l'historique PHP, qui est basé sur l'historique système ou un fichier, en fonction de la configuration de error_log. C'est l'option par défaut.
//     1 message est envoyé par email à l'adresse destination. C'est le seul type qui utilise le quatrième paramètre additional_headers.
//     2 N'est plus une option.
//     3 message est ajouté au fichier destination. Aucune nouvelle ligne (retour chariot) n'est automatiquement ajoutée à la fin de la chaîne message.
//     4 message est envoyé directement au gestionnaire d'identification SAPI.
//

// On veut écrire dans un fichier, on utilise donc 3
error_log($msg,3,DEBUG_LOG_FILE);

// Utilisation de plusieurs niveaux de DEBUG
define('DEBUG_LEVEL',5); // On positionne le niveau de DEBUG à 5, les messages de type 5, 4, 3, 2, 1 seront affichés. Si le niveau était 0, le test (DEBUG_LEVEL) serait faux, pas de DEBUG (cas en exploitation)

// Il faut tester avec des niveaux différents par exemple 8, 7, 5, 3, 2, 1 et surtout 0
$monMessage="";
$monTab=array("a"=>"aa", "orange"=>"poire", 9=>10, 3=>"Je sais pas", 21=>"Pas possible avec 2 dés");
switch (DEBUG_LEVEL)
{
    case 7 : $monMessage.="<br/> (7) un truc vraiment très détaillé";
    // pas de break ; permet de faire aussi le niveau après
    case 6 : // on fait rien pour 6
    case 5 : // on veut afficher dans ce cas le tableau
    // Remarque de la documentation
    // 
    // Liste de paramètres ¶
    // 
    // value
    // 
    //     L'expression à afficher.
    // return
    // 
    //     Si vous voulez obtenir le résultat de print_r() dans une chaîne, utilisez le paramètre return. Lorsque ce paramètre vaut true, print_r() retournera l'information plutôt que de l'afficher.
    // 
    //
    // On prevoit de l'afficher à l'écran, pour faire joli on se met en mode préformatté
    $monMessage.="<br/><pre>".print_r($monTab,true)."</pre>";
    case 4:
    case 3:
    case 2: $monMessage.="<br/>Ici le niveau 2";
    case 1: $monMessage.="<br/>Hein?";
            break; // On sort !
 default : // Ne rien faire surtout !
}

if (DEBUG_LEVEL) 
  echo $monMessage;
else
  echo "Niveau de DEBUG : ".$DEBUG_LEVEL;
?>

