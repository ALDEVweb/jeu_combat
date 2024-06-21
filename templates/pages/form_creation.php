<?php

// template : affiche le formulaire de création d'un personnage
// parametres : aucun

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création d'un personnage</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="fond creation"></div>
    <?php include "templates/fragments/header.php"; ?>
    <main>
        <div class="container flex w300p mrlauto j-center">
            <div>
                <h2 class="w100 yellow fs16">Crée ton personnage</h1>
                <form class="mt32 flex column" action="creer.php" method="post">
                    <div class="flex a-center">
                        <label for="pseudo" class="yellow mr20 w150p fs12">Pseudo : </label>
                        <input class="w130p" type="text" name="pseudo" id="pseudo_connexion" value="<?= $pseudo ?>">
                    </div>
                    <?php 
                        if($verif === 1){
                            echo "<p class='fs10 red'>Ce pseudo est déjà utilisé !</p>";
                        }else if($error === 1 && $pseudo === ""){
                            echo "<p class='fs10 red'>Tu dois choisir un pseudo !</p>";
                        }
                        include "templates/fragments/select_emogi.php"; 
                        if($error === 1 && $emogi_select === ""){
                            echo "<p class='fs10 red'>Tu dois choisir un emogi !</p>";
                        }
                    ?>
                    <div class="flex mt16 a-center">
                        <label for="mdp" class="yellow mr20 w150p fs12">Password : </label>
                        <input class="w80p" type="password" name="mdp_creation" id="mdp_creation" value="<?= $mdp ?>">
                        <p id="btnMdpCrea" class="fs12 ml16 w34p txt-center btnActif">👁</p>
                    </div>
                    <?php
                        if($error === 1 && $mdp === ""){
                            echo "<p class='fs10 red'>Tu dois choisir un mot de passe !</p>";
                        }
                    ?>
                    <div class="flex mt16 a-center">
                        <label class="yellow mr20 w150p fs12">Confirme password : </label>
                        <input class="w80p" type="password" name="mdpVerif_creation" id="mdpVerif_creation" value="<?= $mdpVerif ?>">
                        <p id="btnMdpVerif" class="fs12 ml16 w34p txt-center btnActif">👁</p>
                    </div>
                    <?php
                        if($error === 1 && $mdpVerif === ""){
                            echo "<p class='fs10 red'>Tu dois confirmer ton mot de passe !</p>";
                        }else if($error === 1 && $mdpVerif !== $mdp){
                            echo "<p class='fs10 red'>Tu t'es trompé dans la confirmation de ton mot de passe !</p>";
                        }
                    ?>
                    <div class="carac flex column">
                        <p class="yellow mt32 fs16">Caractéristiques de ton personnage :</p>
                        <p class="yellow mt8 fs12">Tu dispose de 15 points à répartir entre les différentes caractéristiques (minimum 3 points et maximum 10 points par caractéristique)</p>
                        <div class="flex a-center mt16">
                            <label for="res" class="yellow mr60 w150p fs12">🛡️ Résistance (RES) : </label>
                            <input type="number" name="res" id="res" min="3" max="10" value="<?= $res ?>">
                        </div>
                        <div class="flex a-center mt16">
                            <label class="yellow mr60 w150p fs12">⚔️ Force (FOR) : </label>
                            <input type="number" name="for" id="for" min="3" max="10" value="<?= $for ?>">
                        </div>
                        <div class="flex a-center mt16">
                            <label class="yellow mr60 w150p fs12">⚡ Agilité (AGI) : </label>
                            <input type="number" name="agi" id="agi" min="3" max="10" value="<?= $agi ?>">
                        </div>
                        <?php
                            if($carac !== 15){
                                echo "<p class='mt8 fs10 red'>Le total des caractéristiques doit être égal à 15 ! (ni plus, ni moins)</p>";
                            }
                        ?>
                    </div>
                    <input class="wfit mt32 fs12 btnActif" type="submit" value="Créer mon personnage">
                </form>
            </div>
            <div class="w100 flex j-end"><a href="afficher_jeu.php"><button class="wfit mt48 fs12 btnActif">Annuler</button></a></div>
        </div>
    </main>
    <script src="js/form_crea.js" defer></script>
</body>
</html>