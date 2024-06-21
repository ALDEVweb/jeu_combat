<?php

// controleur ajax surveillant l'inactiviter pour ajouter 1 point d'agi toute les 3s.
// parametre : $iduser - id de l'utilisateur connecté
//             $pos - position du joueur
//             $date - date en direct
//             $lastDate - date de la derniere attaque du joueur

// initialisation
require_once "utils/init.php";

// récupération
$idUser = session_isconnected() ? session_idconnected() : 0;

$perso = new personnage($idUser);
$pos = $perso->get("pos");
$agi = $perso->get("agi");
$date = time();

if(isset($_SESSION["date-agi-attrib"])){
    $lastTime = $_SESSION["date-agi-attrib"];
}else{
    $histo = new historique();
    $dateHisto = $histo->lastAttack($idUser);
    $dateString = $dateHisto["date"];
    $lastTime = strtotime($dateString);
}
$ecart = $date - $lastTime;

// traitement

// si on est dans les piece 1 à 9, que l'agi est <15, et que l'éart entre lastDate et $date est > à 3s
if($agi < 15 && $pos > 0 && $pos < 10 && $ecart >= 3){
    // alors j'ajoute 1 agi par 3s d'écart et si agi dépasse 15 je fixe a 15 puis je charge dans la bdd
    $newAgi = $agi + ($ecart / 3);
    if($newAgi > 15){
        $newAgi = 15;
    }
    $perso->set("agi", $newAgi);
    $perso->update();
    $_SESSION["date-agi-attrib"] = time();
}else{
    $newAgi = $agi;
}

// retour
echo json_encode(["agi" => $newAgi]);