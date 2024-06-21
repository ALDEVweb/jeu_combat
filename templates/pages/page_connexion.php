<?php

// template : affiche la page de connexion 
// parametre aucun

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de connexion</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="fond accueil"></div>
    <?php include "templates/fragments/header.php"; ?>
    <main>
        <div class="container flex w300p mrlauto">
            <div>
                <h2 class="w100 yellow fs16">Connexion</h1>
                <form class="mt32 flex column" action="connecter.php" method="post">
                    <div class="flex">
                        <label class="yellow w100p fs12">Pseudo : </label>
                        <input class="w130p" type="text" name="pseudo" id="pseudo_connexion">
                    </div>
                    <div class="flex mt16 a-center">
                        <label class="yellow w100p fs12">Password : </label>
                        <input class="w80p" type="password" name="mdp" id="mdp_connexion">
                        <p id="btnMdpConnect" class="fs12 ml16 w34p txt-center btnActif">👁</p>
                    </div>
                    <input class="mt32 wfit fs12 btnActif" type="submit" value="Me connecter">
                </form>
                <?php
                if($error == 1){
                    ?>
                    <p class="mt8 fs10 red">Il y a une erreur de saisie sur ton pseudo ou ton mot de passe</p>
                    <?php
                }
                ?>
            </div> 
            <div class="w100 flex j-end"><a class="mt80" href="afficher_regle.php"><button class="fs10 btnActif">📜 Règles du jeu</button></a></div>            
            <div class="flex j-end w300p mrlauto mt80">
                <p class="w100 txt-end yellow fs12">Pas encore de personnage ?</p>
                <div class="w100 flex j-end"><a href="afficher_form_creation.php"><button class="mt16 wfit fs12 btnActif">Créer un personnage</button></a></div>
            </div>
        </div>
    </main>
    <script src="js/connexion.js" defer></script>
</body>
</html>