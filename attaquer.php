<?php

// controleur ajax : lance les différentes méthodes permettant de générer un combat
// parametres : $_session(idUser) - id deu joueur attaquant
//              $_get(idAdv) - id du joueur attaqué
// retour : template fight avec détail du combat ($histo avec histo du combat)

// initialisation
require_once "utils/init.php";

// récupération
$idUser = session_isconnected() ? session_idconnected() : 0;
$idAdv = isset($_GET["idAdv"]) ? $_GET["idAdv"] : 0;


// traitement
$attaquant = new personnage($idUser);
$defenseur = new personnage($idAdv);
$histo = new historique();
$date = date("Y-m-d H:i:s");
$histo->set("date", $date);
$histo->set("attaquant", $idUser);
$histo->set("defenseur", $idAdv);
$histo->set("action", "attaque");

// transformation des donnée non numérique en donnée numérique
if(!is_numeric($attaquant->get("for"))){
    $forAtt = intval($attaquant->get("for"));
}else{
    $forAtt = $attaquant->get("for");
}
if(!is_numeric($attaquant->get("pv"))){
    $pvAtt = intval($attaquant->get("pv"));
}else{
    $pvAtt = $attaquant->get("pv");
}
if(!is_numeric($attaquant->get("agi"))){
    $agiAtt = intval($attaquant->get("agi"));
}else{
    $agiAtt = $attaquant->get("agi");
}
if(!is_numeric($attaquant->get("res"))){
    $resAtt = intval($attaquant->get("res"));
}else{
    $resAtt = $attaquant->get("res");
}
if(!is_numeric($defenseur->get("for"))){
    $forDef = intval($defenseur->get("for"));
}else{
    $forDef = $defenseur->get("for");
}
if(!is_numeric($defenseur->get("pv"))){
    $pvDef = intval($defenseur->get("pv"));
}else{
    $pvDef = $defenseur->get("pv");
}
if(!is_numeric($defenseur->get("agi"))){
    $agiDef = intval($defenseur->get("agi"));
}else{
    $agiDef = $defenseur->get("agi");
}
if(!is_numeric($defenseur->get("res"))){
    $resDef = intval($defenseur->get("res"));
}else{
    $resDef = $defenseur->get("res");
}

// l'attaquand attaque avec sa force, le defenseur se defend
$resultat = $defenseur->defend($forAtt);
if($resultat === "esquive"){
    // si resultat = esquive
    $histo->set("result", "esquive");
    // match nul et def perd 1 agi
    $newAgiDef = $agiDef-1;
    if($newAgiDef >= 0){
        $defenseur->set("agi", $newAgiDef);
        $histo->set("agi_def", -1);
    }
    // si foratt > 10
    if($forAtt > 10){
        // un for devient un res pour l'attaquant
        $histo->set("detail", "forToRes");
        $newForAtt = $forAtt-1;
        $newResAtt = $resAtt+1;
        $attaquant->set("for", $newForAtt);
        $attaquant->set("res", $newResAtt);
    }
}else if($resultat === "riposte"){
    // si resultat = riposte
    // historise
    $histo->set("result", "riposte");
    // le defenseur attaque avec sa force, l'attaquand se defend et je recup le resultat
    $resultatR = $attaquant->defend($forDef);
    // si resultat = esquive
    if($resultatR === "esquive"){
        $histo->set("riposte", "esquive");
        // match nul et def perd 1 agi
        $newAgiAtt = $agiAtt-1;
        if($newAgiAtt >= 0){
            $attaquant->set("agi", $newAgiAtt);
            $histo->set("agi_att", -1);
        }
        // si fordef > 10
        if($forDef > 10){
            // un for devient un res pour le defendant
            $histo->set("detail", "forToRes");
            $newForDef = $forDef-1;
            $newResDef = $resDef-1;
            $defenseur->set("for", $newForDef);
            $defenseur->set("res", $newResDef);
        }
    }else if($resultatR === "défaite"){
        // si resultat = defaite - defaite de la riposte dc victoire de l'attaquant
        $histo->set("riposte", "victoire");
        // def perd 2pv
        // si def pas dead
        if($pvDef-2 > 0){
            $newPvDef = $pvDef-2;
            $defenseur->set("pv", $newPvDef);
            $histo->set("pv_def", -2);  
            // si agiatt < 15
            if($agiAtt < 15){
                // agiatt += 1
                $newAgiAtt = $agiAtt+1;
                $attaquant->set("agi", $newAgiAtt);
                $histo->set("agi_att", +1);
            }else{
                // si agiatt = 15
                // pvatt +=1
                $newPvAtt = $pvAtt+1;
                $attaquant->set("pv", $newPvAtt);
                $histo->set("pv_att", 1);
            }        
        }else{
            // si def dead :gagne pvdef
            $defenseur->set("pv", 0); 
            $defenseur->set("pos", 11); 
            $histo->set("pv_def", 0);  
            // si agiatt+pvdef <=15
            if($agiAtt+$pvDef <= 15){
                // agiatt += pvdef
                $newAgiAtt = $agiAtt+$pvDef;
                $attaquant->set("agi", $newAgiAtt);
                $histo->set("agi_att", $pvDef);
            }else{
                // si agiatt+pvdef > 15
                // agiatt += 15-agiatt
                $gainAgiAtt = 15-$agiAtt;
                if($agiAtt < 15){
                    $newAgiAtt = $pvAtt+$gainAgiAtt;
                    $attaquant->set("agi", $newAgiAtt);
                    $histo->set("agi_att", $gainAgiAtt);  
                }
                if($pvAtt < 100)
                    // pvatt += pvdef-(15-agiatt)
                    $gainPvAtt = $pvDef-$gainAgiAtt;
                    $newPvAtt = $pvAtt+$gainPvAtt;
                    if($newPvAtt <= 100){
                        $attaquant->set("pv", $newPvAtt);
                        $histo->set("agi_att", $gainPvAtt); 
                    } 
            }   
        }
    }else if($resultatR === "victoire"){
        // résultat = victoire de la riposte dc defaite de l'attaquant
        $histo->set("riposte", "defaite");
        // att perd 1pv
        if($pvAtt > 0){
            $histo->set("pv_att", -1);
            $newPvAtt = $pvAtt - 1;
            $attaquant->set("pv", $newPvAtt);
            if($newPvAtt == 0){
                $attaquant->set("pos", 11);
                $histo->set("pv_att", 0);
            }
        }
        // defenseur gagne 1pv
        if($pvDef < 100){
            $histo->set("pv_def", 1);
            $newPvDef = $pvDef+1;
            $defenseur->set("pv", $newPvDef);
        }
    }
}else if($resultat === "victoire"){
    // si resultat = victoire
    $histo->set("result", "victoire");
    // def perd foratt-resdef
    // si def pas dead
    $ecartForRes = $forAtt-$resDef;
    $newPvDef = $pvDef-$ecartForRes;
    if($newPvDef > 0){
        $defenseur->set("pv", $newPvDef);
        $histo->set("pv_def", $ecartForRes);    
        // si agiatt < 15
        if($agiAtt < 15){
            // agiatt += 1
            $newAgiAtt = $agiAtt+1;
            $attaquant->set("agi", $newAgiAtt);
            $histo->set("agi_att", 1);
        }else if($pvAtt < 100){
            // si agiatt = 15
            // pvatt +=1
            $newPvAtt = $pvAtt+1;
            $attaquant->set("pv", $newPvAtt);
            $histo->set("pv_att", 1);
        }          
    }else{
        // si def dead :gagne pvdef
        $defenseur->set("pv", 0); 
        $defenseur->set("pos", 11); 
        $histo->set("pv_def", 0);  
        // si agiatt+pvdef <=15
        if($agiAtt+$pvDef <= 15){
            // agiatt += pvdef
            $newAgiAtt = $agiAtt+$pvDef;
            $attaquant->set("agi", $newAgiAtt);
            $histo->set("agi_att", $pvDef);
        }else{
            // si agiatt+pvdef > 15
            // agiatt += 15-agiatt
            $gainAgiAtt = 15-$agiAtt;
            $newAgiAtt = $pvAtt + $gainAgiAtt;
            $attaquant->set("agi", $newAgiAtt);
            $histo->set("agi_att", $gainAgiAtt);  
            // pvatt += pvdef-(15-agiatt)
            $gainPvAtt = $pvDef-$gainAgiAtt;
            if($pvAtt+$gainPvAtt <= 100){
                $newPvAtt = $pvAtt + $gainPvAtt;
                $attaquant->set("pv", $newPvAtt);
                $histo->set("agi_att", $gainPvAtt);  
            }else{
                $attaquant->set("pv", 100);
            }
        }   
    }
}else if($resultat === "defaite"){
    // si resultat = defaite
    $histo->set("result", "defaite");
    // att perd 1pv
    if($pvAtt > 0){
        $histo->set("pv_att", -1);
        $newPvAtt = $pvAtt - 1;
        $attaquant->set("pv", $newPvAtt);
        if($newPvAtt == 0){
            $attaquant->set("pos", 11);
            $histo->set("pv_att", 0);
        }
    }
}



$attaquant->update();
$defenseur->update();
$histo->insert();    

// retour
echo "une attaque à eu lieu";