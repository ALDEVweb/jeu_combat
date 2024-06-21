<?php

// controleur ajax : modif attribut ajoute 1 res et enleve 1 for ainsi que 3 agi
// parametre : utilisateur connecté
// retour jso des nouvelles carac

// initialisation
require_once "utils/init.php";

// récupération
$idUser = session_isconnected() ? session_idconnected() : 0;

// traitement
$perso = new personnage($idUser);
$for = $perso->get("for");
$agi = $perso->get("agi");
$res = $perso->get("res");

$newFor = $for -1;
$newAgi = $agi -3;
$newRes = $res +1;

$perso->set("for", $newFor);
$perso->set("agi", $newAgi);
$perso->set("res", $newRes);

$perso->update();

$histo = new historique();
$histo->set("attaquant", $idUser);
$histo->set("action", "attribut");
$histo->set("result", "forToRes");
$date = date("Y-m-d H:i:s");
$histo->set("date", $date);

$histo->insert();

// retour
echo json_encode(["for" => $newFor, "agi" => $newAgi, "res" => $newRes]);