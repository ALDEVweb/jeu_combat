<?php

// controleur ajax : modif attribut ajoute 1 for et enleve 1 res ainsi que 3 agi
// parametre : utilisateur connecté
// retour jso des nouvelles carac

// initialisation
require_once "utils/init.php";

// récupération
$idUser = session_isconnected() ? session_idconnected() : 0;

// traitement
$perso = new personnage($idUser);
$res = $perso->get("res");
$agi = $perso->get("agi");
$for = $perso->get("for");

$newRes = $res -1;
$newAgi = $agi -3;
$newFor = $for +1;

$perso->set("res", $newRes);
$perso->set("agi", $newAgi);
$perso->set("for", $newFor);

$perso->update();

$histo = new historique();
$histo->set("attaquant", $idUser);
$histo->set("action", "attribut");
$histo->set("result", "resToFor");
$date = date("Y-m-d H:i:s");
$histo->set("date", $date);

$histo->insert();

// retour
echo json_encode(["res" => $newRes, "agi" => $newAgi, "for" => $newFor]);