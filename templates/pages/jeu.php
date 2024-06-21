<?php

// template : affiche l'ecran de jeu
// parametres : $perso : objet personnage avec carac - pseudo - pv - for -   agi - res - pos - date)
//              $histo : tableau d'objet historique indexé par l'id
//              $adversaire : liste des joueur présent dans la pièce"
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeu</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="containFond">
        <div class="fond <?= $fonds[$pos] ?>"></div>
    </div>
    <?php include "templates/fragments/header.php"; ?>
    <main class="w300p mrlauto">
        <div class="perso">
            <div class="w100 flex j-between a-center">
                <div class="flex j-between a-center">
                    <a href="deconnecter.php"><button class="fs10 w20p btnActif">🚪</button></a>
                    <a href="afficher_regle.php"><button class="fs10 w20p btnActif">📜</button></a>
                </div>
                <h2 class="fs20 yellow"><?= $emogis[$perso->get("emogi")] ?> <?= $perso->get("pseudo") ?></h2>
                <p id="pv" class="fs16">🩸 : <?= $perso->get("pv") ?>/100</p>
            </div>
            <ul class="w100 flex j-between mt16 a-center">
                <li id="for" class="fs16 yellow">⚔️ : <?= $perso->get("for") ?>/15</li>
                <li id="res" class="fs16 yellow">🛡️ : <?= $perso->get("res") ?>/15</li>
                <li id="agi" class="fs16 yellow">⚡ : <?= $perso->get("agi") ?>/15</li>
            </ul>
            <div class="w100 attribut flex j-center gap32 mt16 a-center">
                <button id="forToRes" class="fs10 w75p">⚔️ ⇒  🛡️</button>
                <p class="yellow fs10">-3 ⚡</p>
                <button id="resToFor" class="fs10 w75p">🛡️ ⇒  ⚔️</button>
            </div>
        </div>
        <div class="piece mt32">
            <div class="flex j-between">
                <p id="ctPv" class="yellow fs10 a-end">+<?= $preced ?> 🩸</p>
                <h2 id="piece" class="fs14 yellow wfit txt-center"><?= $pieces[$pos] ?></h2>
                <p id="ctAgi" class="yellow fs10 a-end">-<?= $suiv ?> ⚡</p>
            </div>
            <div class="flex j-between mt16">
                <button id="preced" class="fs8 w140p"><?= $pieces[$preced] ?></button>
                <button id="suiv" class="fs8 w140p"><?= $pieces[$suiv] ?></button>
            </div>
        </div>
        <div class="mt32">
            <h2 class="fs12 yellow w100 txt-center">Tes adversaires dans la pièces :<br>(click pour attaquer)</h2>
            <div class="containerAdv mt16">
                <div id="adv" class="flex j-between gap8">
                    <?php include "templates/fragments/adversaires.php"; ?>
                </div>
            </div>
        </div>
        </div>
        <div class="histo mt32">
            <h2 class="fs12 yellow w100 txt-center">Historique des actions :</h2>
            <div class="containerHisto mt16">
                <div class="listContainer">
                    <ul id="histo">
                        <?php include "templates/fragments/histo.php"; ?>
                    </ul>
                </div>
            </div>
        </div>
    </main>
    <script src="js/combat.js" defer></script>
</body>
</html>
