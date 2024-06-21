<?php

// controleur ajax : récupère les caractéristique du personnage et active ou desactive les bouton action en fonction
// parametres : $idUser - id de l'utilisateur connecté
// retour : fichier json : pv - for - res - agi - btnactif/inactif

// initialisation
require_once "utils/init.php";

// récupération
$idUser = session_isconnected() ? session_idconnected() : 0;
$perso = new personnage($idUser);
$pos = $perso->get("pos");

// traitement
$suiv = $pos + 1;
// si on a plus d'agi que le numero de la piece suivante, le btn est actif
if($perso->get("agi") >= $suiv && $pos < 10){
    $btnSuiv = 1;
}else{
    $btnSuiv = 0;
}
// condition pour activer le btn preced
if($pos > 1 && $pos < 10){
    $btnPreced = 1;
}else{
    $btnPreced = 0;
}
// condition pour activé btn forToRes
if($perso->get("agi") >= 3 && $perso->get("for") > 0 && $perso->get("res") < 15){
    $btnForToRes = 1;
}else{
    $btnForToRes = 0;
}
// condition pour activé btn resToFor
if($perso->get("agi") >= 3 && $perso->get("res") > 0 && $perso->get("for") < 15){
    $btnResToFor = 1;
}else{
    $btnResToFor = 0;
}


// renvoi
header('Content-Type: application/json; charset=utf-8');

$data = ["pv" => $perso->get("pv"), "for" => $perso->get("for"), "res" => $perso->get("res"), "agi" => $perso->get("agi"), "btnSuiv" => $btnSuiv, "btnPreced" => $btnPreced, "btnForToRes" => $btnForToRes, "btnResToFor" => $btnResToFor];

echo json_encode($data);