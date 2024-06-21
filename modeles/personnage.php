<?php

class personnage extends _model {

    protected $table = "personnage";
    protected $fields = ["pseudo", "emogi", "mdp", "pv", "for", "agi", "res", "pos", "date"];
    
    function verifPseudo($pseudo){
        // role : vérifie si le pseudo testé existe deja dans la base
        // parametre : $pseudo - pseudo à vérifier
        // retour : true si pseudo dispo / false sinon

        // construction
        $sql = "SELECT `pseudo` FROM `personnage` WHERE `pseudo` = :pseudo";
        $param = [":pseudo" => $pseudo];
        // préparation
        $bdd = static::bdd();
        $req = $bdd->prepare($sql);

        // execution
        if(!$req->execute($param)){
            // erreur syntaxe, code de debug
            echo "echec sql : $sql";
            print_r($param);
            return false;
        }

        //récupération
        if($req->fetch(PDO::FETCH_ASSOC)){
            // si il y a une réponse c'est qu'un pseudo existe
            return false;
        }else{
            // sinon pseudo libre
            return true;
        }

    }

    function defend($att){
        // role compare la force d'un joueur attaquand avec les attribut d'un joueur defendand
        // parametres : $for - force de l'attaquant
        // retour : esquive / riposte / victoire / defaite

        // si valeur nom numérique, on convertit
        if(!is_numeric($this->get("agi"))){
            $agi = intval($this->get("agi"));
        }else{
            $agi = $this->get("agi");
        }
        if(!is_numeric($this->get("for"))){
            $for = intval($this->get("for"));
        }else{
            $for = $this->get("for");
        }
        if(!is_numeric($this->get("res"))){
            $res = intval($this->get("res"));
        }else{
            $res = $this->get("res");
        }

        if($agi - $att > 2){
            // Si notre agilité dépasse la force d'attaque d'au moins 3 points, on esquive.
            return "esquive";
        }else if($for > $att){
            // Si notre force est supérieure strictement à celle de l'attaque, on riposte
            return "riposte";
        }else if($res >= $att){
            // si notre résistance est supérieure ou égale à la force de l'attaque, on gagne
            return "defaite";
        }else{
            // si elle est inférieure, on le perd
            return "victoire";
        }
    }

    function setMdp($mdp){
        // role : crypte mdp avant de le charger dans la bdd
        // parametres : $mdp - le mdp à crypter
        // retour : true/false

        // cryptage
        $hash = password_hash($mdp, PASSWORD_DEFAULT);

        // stockage
        $this->values["mdp"] = $hash;

        // retour
        return true;
    }

    function connexion($pseudo, $mdp){
        // role : recherche dans la base de donnée un utilisateur correspondant aux critere de recherche
        // parametre : $log = mail de l'utilisateur
                    // $pwd = pwd de l'utilisateur
        // retour : l'id de l'utilisateur

        // construction
        $sql = "SELECT `id`, `mdp` FROM `personnage` WHERE `pseudo` = :pseudo";
        $param = [":pseudo" => $pseudo];

        // préparation
        $bdd = static::bdd();
        $req = $bdd->prepare($sql);
        // éxecution
        if(! $req->execute($param)){
            // erreur syntaxe - code de debug
            echo "Echec sql : $sql";
            print_r($param);
            exit;
        }

        // récupération
        $result = $req->fetch(PDO::FETCH_ASSOC);
        if(isset($result)){
            if(password_verify($mdp, $result["mdp"])){
                $id = $result["id"];
            }else{
                $id = 0;
            }            
        }else{
            $id = 0 ;
        }
        $this->id = $id;

        // retour
        return $this->id;
    }

    function listeAdversaire(){
        // Role : récupère la liste des personnage dans la meme sale que l'utilisateur
        // parametre : this id - id de l'utilisateur connecté
        //             this pos - position de l'utilisateur connecté
        // retour : $histo - tableau d'objet historique indéxé par l'id

        // construction
        $sql = "SELECT `id`, `pseudo`, `emogi`, `pv` FROM `personnage` WHERE `id` != :id AND `pos` = :pos";
        $param = [":id" => $this->id(), ":pos" => $this->get("pos")];

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
        $persos = [];
        while($result = $req->fetch(PDO::FETCH_ASSOC)){
            $personnage = [];
            $personnage["id"] = $result["id"];
            $personnage["pseudo"] = $result["pseudo"];
            $personnage["emogi"] = $result["emogi"];
            $personnage["pv"] = $result["pv"];
            $persos[] = $personnage;
        }

        // retour
        return $persos;
    }
}