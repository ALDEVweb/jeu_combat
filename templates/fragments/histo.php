<?php

// fragment liste l'historique du joueur
// parametres : $perso - objet utilisateur connecté
//              $histo - liste des historique de l'utilisateur

// pour chaque objet historique de la liste
foreach($histos as $id => $histo){
    //je récupère la date de l'histo
    $date = $histo->get("date");
    echo "<li class='fs12 yellow'><span class='fs10'>$date</span> :</li>";
    echo "<li class='w100 txt-end fs12 yellow'>";
    // si je suis l'attaquant
    if($histo->get("attaquant") === $idUser){
        // si action = creation
        if($histo->get("action") === "creation"){
            $emogi = $perso->get("emogi");
            $logo = $emogis[$emogi];
            $pseudo = $perso->get('pseudo');
            echo "création de ton personnage ($logo $pseudo)";
        }else if($histo->get("action") === "mouvement"){
            // si action = mouvement
            $piece = $histo->get("detail");
            $nomPiece = $noms[$piece];
            // si result = suivante
            if($histo->get("result") === "suivante"){
                // si piece = 10
                if($piece == "10"){
                    echo "<span class='green'>tu accède à la sortie du donjon, le jeu est terminé !</span>";
                }else{
                //sinon
                echo "⇒ tu accède $nomPiece (<span class='red'>-$piece ⚡</span>)";
                }
            }else if($histo->get("result") === "precedente"){
                // si result = precedente
                echo "⇐ tu accède $nomPiece (<span class='green'>+$piece 🩸</span>)";
            }
        }else if($histo->get("action") === "attribut"){
            // si action = attributs
            // si result = forToRes
            if($histo->get("result") === "forToRes"){
                echo "modification de tes attributs (⚔️ ⇒ 🛡️, <span class='red'>-3 ⚡</span>)";
            }else if($histo->get("result") === "resToFor"){
            // si result = resToFor
                echo "modification de tes attributs (🛡️ ⇒ ⚔️, <span class='red'>-3 ⚡</span>)";
            }
        }else if($histo->get("action") === "attaque"){
            // si action = attaque (j'attaque)
            // je récupère les info de l'adversaire, j'affiche que je l'attaque
            $adv = $histo->getTarget("defenseur");
            $advPseudo = $adv->get("pseudo");
            $advEmogi = $emogis[$adv->get("emogi")];
            echo "tu attaque $advEmogi $advPseudo, ";
            // si result = esquive
            if($histo->get("result") === "esquive"){
                echo "il esquive, <span class='orange'>match nul </span>";
                if($histo->get("detail") === "forTores"){
                    echo "(⚔️ ⇒ 🛡️)";
                }
            }else if($histo->get("result") === "riposte"){
            // si result = riposte
                echo "il riposte, ";
                if($histo->get("riposte") === "esquive"){
                    echo "tu esquives, <span class='orange'>match nul </span> (<span class='red'>-1 ⚡</span>)";
                }else if($histo->get("riposte") === "victoire"){
                // si result = victoire
                    echo "tu <span class='green'>gagne</span> (";
                    $agi = $histo->get("agi_att");
                    if($agi != 0){
                        echo "(<span class'green'>+$agi</span> ⚡)";
                    }
                    $pv = $histo->get("pv_att");
                    if($pv != 0){
                        echo " (<span class'green'>+$pv</span> 🩸)";
                    }
                    echo ")";
                    if($histo->get("pv_def") == 0){
                        echo " il est mort";
                    }
                }else if($histo->get("riposte") === "defaite"){
                // si result = defaite
                    echo "tu <span class='red'>perd</span> (<span class='red'>-1</span> 🩸)";
                }
            }else if($histo->get("result") === "victoire"){
            // si result = victoire
                echo "tu <span class='green'>gagne</span> le combat (";
                $agi = $histo->get("agi_att");
                if($agi != 0){
                    echo "<span class'green'>+$agi</span> ⚡";
                }
                $pv = $histo->get("pv_att");
                if($pv != 0){
                    echo " <span class'green'>+$pv</span> 🩸";
                }
                echo ")";
                if($histo->get("pv_def") == 0){
                    echo " il est mort";
                }
            }else if($histo->get("result") === "defaite"){
            // si result = defaite
                $pv = $histo->get("pv_att");
                echo "tu <span class='red'>perds</span> le combat (<span class='red'>-1</span> 🩸)";
            }
        }
    }else if($histo->get("defenseur") === $idUser){
        // si je suis defenseur
        // je récupère les info de l'adversaire, j'affiche que je l'attaque
        $adv = $histo->getTarget("attaquant");
        $advPseudo = $adv->get("pseudo");
        $advEmogi = $emogis[$adv->get("emogi")];
        // si action = attaque (je me fais attaquer)
        if($histo->get("action") === "attaque"){
            echo "$advEmogi $advPseudo t'attaque, ";
            // si result = esquive
            if($histo->get("result") === "esquive"){
                echo "tu esquive, <span class='orange'>match nul</span> (<span class='red'>-1</span> ⚡)";
            }else if($histo->get("result") === "riposte"){
            // si result = riposte
                echo "tu riposte";
            }else if($histo->get("result") === "victoire"){
            // si result = victoire
                $pv = $histo->get("pv_def");
                echo "tu <span class='red'>perd</span> le combat (<span class='red'>-$pv</span> 🩸)";
                if($histo->get("pv_def") == 0){
                    echo " tu est mort";
                }
            }else if($histo->get("result") === "defaite"){
            // si result = defaite
                echo "tu <span class='green'>gagne</span> le combat";
            }
        }else if($histo->get("action") === "riposte"){
            // si action = riposte (j'attaque à mon tour)
            // si result = esquive
            if($histo->get("result") === "esquive"){
                echo "$advEmogi $advPseudo esquive ta riposte, <span class='orange'>match nul</span>";
                if($histo->get("detail") === "forTores"){
                    echo " (⚔️ ⇒ 🛡️)";
                }
            }else if($histo->get("result") === "victoire"){
                // si result = victoire
                echo "tu <span class='red'>perd</span> la riposte (<span class='red'>-2</span> 🩸)";
                if($histo->get("pv_def") == 0){
                    echo " tu est mort";
                }
            }else if($histo->get("result") === "defaite"){
                // si result = defaite
                echo "tu <span class='green'>gagne</span> la riposte (<span class='green'>+1</span> 🩸)";
            }
        }
    } 
    echo "</li>";  
}

