<?php

// controleur : dde l'affichage du formulaire de création d'un personnage
// parametres : $GET si prb de saisi lors de la créa


// initialisation
require_once "utils/init.php";

// récupération

$verif = isset($_GET["verif"]) ? 1 : 0;
$error = isset($_GET["error"]) ? 1 : 0;
$pseudo = isset($_GET["pseudo"]) && $_GET["pseudo"] !== "" ? $_GET["pseudo"] : "";
$emogi_select = isset($_GET["emogi"]) && $_GET["emogi"] !== "" ? $_GET["emogi"] : "";
$mdp = isset($_GET["mdp"]) && $_GET["mdp"] !== "" ? $_GET["mdp"] : "";
$mdpVerif = isset($_GET["mdpVerif"]) && $_GET["mdpVerif"] !== "" ? $_GET["mdpVerif"] : "";
$for = isset($_GET["for"]) ? $_GET["for"] : 5;
$agi = isset($_GET["agi"]) ? $_GET["agi"] : 5;
$res = isset($_GET["res"]) ? $_GET["res"] : 5;
$carac = $for + $agi + $res;






// affichage
include "templates/pages/form_creation.php";