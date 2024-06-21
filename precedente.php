<?php

// controleur ajax : modif piece et consomme autant recupere autant de pv que la nouvelle piece
// parametre : utilisateur connecté
// retour json de la nouvelle piece et des piee a afficher dans bouton

// initialisation
require_once "utils/init.php";

// récupération
$idUser = session_isconnected() ? session_idconnected() : 0;

// traitement
$perso = new personnage($idUser);
$pos = $perso->get("pos");
$pv = $perso->get("pv");

$piece = $pos -1;
if($piece == 0){
    $piece = 1;
}
$preced = $piece -1;
$suiv = $piece +1;
$newPv = $pv + $piece;
if($newPv > 100){
    $newPv = 100;
}

$perso->set("pos", $piece);
$perso->set("pv", $newPv);

$perso->update();

$histo = new historique();
$histo->set("attaquant", $idUser);
$histo->set("action", "mouvement");
$histo->set("result", "precedente");
$histo->set("detail", $piece);
$date = date("Y-m-d H:i:s");
$histo->set("date", $date);

$histo->insert();


// retour
echo json_encode(["pv" => $newPv, "piece" => $piece, "preced" => $preced, "suiv" => $suiv]);