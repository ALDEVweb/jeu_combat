<?php

// controleur : Crée un personnage dans la base de donnée
// parametre : $_POST[] : pseudo mdp for agi res - du personnage à crée

// initialistaion
require_once "utils/init.php";


// récupération des param
$pseudo = isset($_POST["pseudo"]) && $_POST["pseudo"] !== "" ? $_POST["pseudo"] : "";
$emogi_select = isset($_POST["emogi"]) && $_POST["emogi"] !== "" ? $_POST["emogi"] : "";
$mdp = isset($_POST["mdp_creation"]) && $_POST["mdp_creation"] !== "" ? $_POST["mdp_creation"] : "";
$mdpVerif = isset($_POST["mdpVerif_creation"]) && $_POST["mdpVerif_creation"] !== "" ? $_POST["mdpVerif_creation"] : "";
$for = isset($_POST["for"]) ? $_POST["for"] : 5;
$agi = isset($_POST["agi"]) ? $_POST["agi"] : 5;
$res = isset($_POST["res"]) ? $_POST["res"] : 5;
$carac = $for + $agi + $res;

$perso = new personnage();
$pseudoVerif = $perso->verifPseudo($pseudo);


// si un champ est mal rempli on réaffiche le formulaire
if($pseudoVerif === false){
    if($mdp === "" || $mdpVerif === "" || $mdpVerif !== $mdp || $carac !== 15){
        header("Location: afficher_form_creation.php?verif=1&error=1&for=$for&agi=$agi&res=$res&pseudo=$pseudo&emogi=$emogi_select&mdp=$mdp&mdpVerif=$mdpVerif");
        exit;
    }else{
        header("Location: afficher_form_creation.php?verif=1&for=$for&agi=$agi&res=$res&pseudo=$pseudo&emogi=$emogi_select&mdp=$mdp&mdpVerif=$mdpVerif");
        exit;
    }
}else if($pseudo === "" || $mdp === "" || $mdpVerif === "" || $mdpVerif !== $mdp || $carac !== 15){
    header("Location: afficher_form_creation.php?error=1&for=$for&agi=$agi&res=$res&pseudo=$pseudo&emogi=$emogi_select&mdp=$mdp&mdpVerif=$mdpVerif");
    exit;
}


//traitement
$personnage = new personnage();
$personnage->set("pseudo", $pseudo);
$personnage->set("emogi", $emogi_select);
$personnage->setMdp($mdp);
$personnage->set("for", $for);
$personnage->set("agi", $agi);
$personnage->set("res", $res);
$personnage->set("pv", 100);
$personnage->set("pos", 0);
$date = date("Y-m-d H:i:s");
$personnage->set("date", $date);

$personnage->insert();
session_connect($personnage->id());

$histo = new historique();
$histo->set("attaquant", $personnage->id());
$histo->set("action", "creation");
$histo->set("date", $date);

$histo->insert();

$_SESSION["last-co"] = $date;

// redirection sur l'écran de jeu
header("Location: afficher_jeu.php");
