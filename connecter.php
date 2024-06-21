<?php

// controleur : connecte l'utilisateur au jeu, verifie que les donnée existe dans lea bdd et le connecte le cas echéant
// parametre : $_post[pseudo, mdp] - info du perso a connecter

// initialisation
require_once "utils/init.php";


$pseudo = isset($_POST["pseudo"]) ? $_POST["pseudo"] : "";
$mdp = isset($_POST["mdp"]) ? $_POST["mdp"] : "";

// traitement
$personnage = new personnage();
$idPerso = $personnage->connexion($pseudo, $mdp);

// si l'id retourné est 0 on réaffiche page co avec msg erreur
if($idPerso === 0){
    header("Location: afficher_jeu.php?error=1");
    exit;
}

// si l'id retourné est > 0 on connecte l'utilisateur et on le redirige vers la page jeu

session_connect($idPerso);

$perso = new personnage($idPerso);
$_SESSION["last-co"] = $perso->get("date");
$date = date("Y-m-d H:i:s");
$perso->set("date", $date);

$perso->update();


header("Location: afficher_jeu.php");