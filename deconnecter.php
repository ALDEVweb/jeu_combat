<?php

// controleur : deconnecte le joueur


//initialisation
require_once "utils/init.php";

// traitement
session_deconnect();

// affichage
header("Location: afficher_jeu.php");