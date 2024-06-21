<?php

// controleur ajax : récupère l'historique relatif à l'utilisateur connecté
//parametres : $idUser - id de l'utilisateur connecté
//retour : fragment histo

require_once "utils/init.php";

include "modeles/tableaux.php";

// récupération
$idUser = session_isconnected() ? session_idconnected() : 0;
$perso = new personnage($idUser);

$historique = new historique();
$histos = $historique->histoPerso($idUser, $_SESSION["last-co"]);

// retour
include "templates/fragments/histo.php";