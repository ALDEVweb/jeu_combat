<?php

// controleur ajax : récupère les adversaires présent dans la meme salle que l'utilisateur
// parametre : $idUser - id de l'utilisateur connecté
// retour : json $adversaires - tableau d'objet perso indexé par l'id

// initialisation
require_once "utils/init.php";

include "modeles/tableaux.php";

// récupération
$idUser = session_isconnected() ? session_idconnected() : 0;
$perso = new personnage($idUser);

// retour
include "templates/fragments/adversaires.php";