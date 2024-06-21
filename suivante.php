<?php

// controleur ajax : modif piece et consomme autant d'agi que le nombre de la nvlle piece
// parametre : utilisateur connecté
// retour json de la nouvelle piece et des piee a afficher dans bouton

// initialisation
require_once "utils/init.php";

// récupération
$idUser = session_isconnected() ? session_idconnected() : 0;

// traitement
$perso = new personnage($idUser);
$pos = $perso->get("pos");
$agi = $perso->get("agi");

$piece = $pos +1;
$preced = $piece -1;
$suiv = $piece +1;
$newAgi = $agi - $piece;

$perso->set("pos", $piece);
$perso->set("agi", $newAgi);

$perso->update();

$histo = new historique();
$histo->set("attaquant", $idUser);
$histo->set("action", "mouvement");
$histo->set("result", "suivante");
$histo->set("detail", $piece);
$date = date("Y-m-d H:i:s");
$histo->set("date", $date);

$histo->insert();


// retour
echo json_encode(["agi" => $newAgi, "piece" => $piece, "preced" => $preced, "suiv" => $suiv]);