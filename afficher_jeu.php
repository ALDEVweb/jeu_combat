<?php 

// Controleur : Si pas d'idUser : dde affichage de la page de connexion, si id, dde l'affichage de l'écran de jeu
// parametre : $_SESSION[id] - id de l'utilisateur connecté
//             $_get[error] : si erreur d'authentification


// initialisation

require_once "utils/init.php";

// surveille si le parametre error est dans le get
$error = isset($_GET["error"]) ? $_GET["error"] : 0;

include "utils/verif_connexion.php";

// récupération

$idUser = session_isconnected() ? session_idconnected() : 0;

include "modeles/tableaux.php";

// traitement

$perso = new personnage($idUser);

$pos = $perso->get("pos");
if($pos == 0){
    $preced = 0;
}else{
    $preced = $pos -1;
}
$suiv = $pos +1;


$historique = new historique();
$histos = $historique->histoPerso($idUser, $_SESSION["last-co"]);

// affichage

include "templates/pages/jeu.php";