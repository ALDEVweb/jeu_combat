<?php

class historique extends _model {

    protected $table = "historique";
    protected $fields = ["attaquant", "defenseur", "action", "result", "riposte", "detail", "agi_att", "pv_att", "agi_def", "pv_def", "date"];
    protected $links = ["attaquant" => "personnage", "defenseur" => "personnage"];
    
    function histoPerso($idUser, $date){
        // Role : récupère l'historique des actions en lien avec l'utilisateur depuis sa dernière connexion (sauf si création de compte)
        // parametre : îdUser - id de l'utilisateur  connecté
        // retour : $histo - tableau d'objet historique indéxé par l'id

        // construction
        $sql = "SELECT `id`, `attaquant`, `defenseur`, `action`, `result`, `riposte`, `detail`, `agi_att`, `pv_att`, `agi_def`, `pv_def`, `date` FROM `historique` WHERE (`attaquant` = :id OR `defenseur` = :id) AND `date` >= :dat ORDER BY `date` DESC";
        $param = [":id" => $idUser, ":dat" => $date];

        // préparation
        $bdd = static::bdd();
        $req = $bdd->prepare($sql);

        //execution
        if(!$req->execute($param)){
            // erreur de syntaxe - code de debug
            echo "echec sql : $sql";
            print_r($param);
            return [];
        }

        // récupération
        $histos = [];
        while($result = $req->fetch(PDO::FETCH_ASSOC)){
            $histo = new historique();
            $histo->loadFromTab($result);
            $histos[$histo->id()] = $histo;
        }


        // retour
        return $histos;
    }

    function lastAttack($idUser){
        // role : récupère la date de la dernière attaque
        // parametre : id de l'utilisateur
        // retour : $date - date de la derniere attaque

        // construction
        $sql = "SELECT `date` FROM `historique` WHERE `attaquant` = :id ORDER BY `date` DESC LIMIT 1";
        $param = [":id" => $idUser];

        // préparation
        $bdd = static::bdd();
        $req = $bdd->prepare($sql);

        // execution
        if(!$req->execute($param)){
            // erreur syntaxe : code de debug
            echo "Echec SQL : $sql";
            print_r($param);
            return "";
        }

        // récupération
        $result = $req->fetchAll(PDO::FETCH_ASSOC);

        // retour
        return $result[0];
    }
}