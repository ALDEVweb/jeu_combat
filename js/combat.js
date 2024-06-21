let forToRes = document.getElementById("forToRes");
let resToFor = document.getElementById("resToFor");
let force = document.getElementById("for");
let agi = document.getElementById("agi");
let res = document.getElementById("res");
let preced = document.getElementById("preced");
let suiv = document.getElementById("suiv");
let pv = document.getElementById("pv");
let position = document.getElementById("piece");
let adv = document.getElementById("adv");
let histo = document.getElementById("histo");
let fond = document.querySelector(".containFond");
let ctPv = document.getElementById("ctPv");
let ctAgi = document.getElementById("ctAgi");


// surveillance del'historique des action
function surveilleHisto(){
    fetch("surveiller_historique.php")
    .then(resp => {
        return resp.text();
    })
    .then( liste => {
        histo.innerHTML = liste;
    })
}
setInterval(surveilleHisto, 500);


// surveillance des adversaires présent dans la pièce
function surveilleAdv(){
    fetch("surveiller_adversaire.php")
    .then(resp => {
        return resp.text();
    })
    .then( liste => {
        detacheSurveilleAttaque();
        adv.innerHTML = liste;
        attacheSurveilleAttaque();
    })
}
setInterval(surveilleAdv, 500);


// surveille l'inactivité du joueur pour ajouter des points d'agilité
function surveilleInactif(){
    fetch("rester_inactif.php")
    .then(resp => {
        return resp.json();
    })
    .then( inactif => {
        afficheAgi(inactif);
    })
}
setInterval(surveilleInactif, 3000);


// surveille les changement des attributs du personnage et les affiche toutes les demi seconde
function surveilleAttributs(){
    fetch("surveiller_caracteristiques.php")
    .then(resp => {
        return resp.json();
    })
    .then(data => {
        affichePv(data)
        afficheAttributs(data);
        afficheAgi(data);
        afficheBtn(data);
        detacheSurveilleClick();
        attacheSurveilleClick();
    })
}
setInterval(surveilleAttributs, 500);


function afficheBtn(data){
    // applique la class btn actif ou inactif selon les data reçu
    if(data.btnPreced == 1){
        if(preced.classList.contains("btnInactif")){
            preced.classList.remove("btnInactif");
        }
        preced.classList.add("btnActif")
    }
    else{
        if(preced.classList.contains("btnActif")){
            preced.classList.remove("btnActif");
        }
        preced.classList.add("btnInactif")
    }
    if(data.btnSuiv == 1){
        if(suiv.classList.contains("btnInactif")){
            suiv.classList.remove("btnInactif");
        }
        suiv.classList.add("btnActif")
    }
    else{
        if(suiv.classList.contains("btnActif")){
            suiv.classList.remove("btnActif");
        }
        suiv.classList.add("btnInactif")
    }
    if(data.btnForToRes == 1){
        if(forToRes.classList.contains("btnInactif")){
            forToRes.classList.remove("btnInactif");
        }
        forToRes.classList.add("btnActif")
    }
    else{
        if(forToRes.classList.contains("btnActif")){
            forToRes.classList.remove("btnActif");
        }
        forToRes.classList.add("btnInactif")
    }
    if(data.btnResToFor == 1){
        if(resToFor.classList.contains("btnInactif")){
            resToFor.classList.remove("btnInactif");
        }
        resToFor.classList.add("btnActif")
    }
    else{
        if(resToFor.classList.contains("btnActif")){
            resToFor.classList.remove("btnActif");
        }
        resToFor.classList.add("btnInactif")
    }
}

function detacheSurveilleClick(){
    forToRes.removeEventListener("click", clickForToRes);
    resToFor.removeEventListener("click", clickResToFor)
    suiv.removeEventListener("click", pieceSuivante)
    preced.removeEventListener("click", piecePrecedente)
}



function attacheSurveilleClick(){
    // surveille le click des boutons modif attributs et lance la fonction associé
    if(forToRes.classList.contains("btnActif")){
        forToRes.addEventListener("click", clickForToRes)
    }
    if(resToFor.classList.contains("btnActif")){
        resToFor.addEventListener("click", clickResToFor)
    }
    // surveille le click des btn change piece et lance fonction associé
    if(suiv.classList.contains("btnActif")){
        suiv.addEventListener("click", pieceSuivante)
    }
    if(preced.classList.contains("btnActif")){
        preced.addEventListener("click", piecePrecedente)
    }
}

function detacheSurveilleAttaque(){
    let adversaires = adv.querySelectorAll("button");
    adversaires.forEach(adversaire =>{
        let id = adversaire.dataset.idadv;
        adversaire.removeEventListener("click", () => {
            attaqueAdv(id)
        })
    })
}



function attacheSurveilleAttaque(){
    let adversaires = adv.querySelectorAll("button");
    adversaires.forEach(adversaire =>{
        let id = adversaire.dataset.idadv;
        if(adversaire.classList.contains("btnActif")){
            adversaire.addEventListener("click", () => {
                attaqueAdv(id)
            })
        }
    })
}

function attaqueAdv(id){
    console.log(`attaque ${id}`);
    fetch(`attaquer.php?idAdv=${id}`)
    .then(resp => {
        return resp.text();
    })
    .then( liste => {
        console.log(liste);
    })
}
    
function clickForToRes(){
    fetch("forToRes.php")
    .then(resp => {
        return resp.json();
    })
    .then(data => {
        afficheAttributs(data);
    })
}
function clickResToFor(){
    fetch("resToFor.php")
    .then(resp => {
        return resp.json();
    })
    .then(data => {
        afficheAttributs(data);
    })
}
function pieceSuivante(){
    fetch("suivante.php")
    .then(resp => {
        return resp.json();
    })
    .then(data => {
        affichePiece(data);
        afficheAgi(data);
    })
}
function piecePrecedente(){
    fetch("precedente.php")
    .then(resp => {
        return resp.json();
    })
    .then(data => {
        affichePiece(data);
        affichePv(data);
    })
}
    


function afficheAttributs(data){
    // role : affiche les bon attributs
    // parametre : data - tableau d'attributs ("for" => $for)
    force.innerText = `⚔️ : ${data.for}/15`;
    res.innerText = `🛡️ : ${data.res}/15`;
}

function affichePiece(data){
    // role : affiche les bon attributs
    // parametre : data - tableau d'attributs ("for" => $for)
    ctPv.innerText = `+${data.preced} 🩸`;
    ctAgi.innerText = `-${data.suiv} ⚡`;
    afficheFond(data.piece);
}

function affichePv(data){
    // role : affiche les pv
    // parametre : data - tableau d'elements
    pv.innerText = `🩸 : ${data.pv}/100`;
    if(data.pv > 75){
        pv.classList.add("green");
    }else if(data.pv > 50 && pv <= 75){
        pv.classList.add("yellow");
    }else if(data.pv > 25 && pv <= 50){
        pv.classList.add("orange");
    }else{
        pv.classList.add("red");
    }if(data.pv == 0){
        fond.innerHTML = "";
        ctPv.innerText = "";
        ctAgi.innerText = "";
        preced.innerText = "⚜️ Salle des âmes perdues ⚜️";
        position.innerText = "⚜️ Salle des âmes perdues ⚜️";
        suiv.innerText = "⚜️ Salle des âmes perdues ⚜️";
        fond.innerHTML = `<div class="fond mort"></div>`;
    }
}

function afficheAgi(data){
    // role : affiche les point d'agi
    // parametre : data - tableau d'elements
    agi.innerText = `⚡ : ${data.agi}/15`;
}

function afficheFond(piece){
    fond.innerHTML = "";
    if(piece == 0){
        preced.innerText = "🏰 Entrée 🏰";
        position.innerText = "🏰 Entrée 🏰";
        suiv.innerText = "🌳 Forêt enchantée 🌳";
        fond.innerHTML = `<div class="fond entree"></div>`;
    }else if(piece == 1){
        preced.innerText = "🏰 Entrée 🏰";
        position.innerText = "🌳 Forêt enchantée 🌳";
        suiv.innerText = "❄️ Caverne de glace ❄️";
        fond.innerHTML = `<div class="fond un"></div>`;
    }else if(piece == 2){
        preced.innerText = "🌳 Forêt enchantée 🌳";
        position.innerText = "❄️ Caverne de glace ❄️";
        suiv.innerText = "🔥 Temple du feu 🔥";
        fond.innerHTML = `<div class="fond deux"></div>`;
    }else if(piece == 3){
        preced.innerText = "❄️ Caverne de glace ❄️";
        position.innerText = "🔥 Temple du feu 🔥";
        suiv.innerText = "📚 Bibliothèque abandonnée 📚";
        fond.innerHTML = `<div class="fond trois"></div>`;
    }else if(piece == 4){
        preced.innerText = "🔥 Temple du feu 🔥";
        position.innerText = "📚 Bibliothèque abandonnée 📚";
        suiv.innerText = "🌷 Jardin souterrain 🌷";
        fond.innerHTML = `<div class="fond quatre"></div>`;
    }else if(piece == 5){
        preced.innerText = "📚 Bibliothèque abandonnée 📚";
        position.innerText = "🌷 Jardin souterrain 🌷";
        suiv.innerText = "💰 Chambre des trésors 💰";
        fond.innerHTML = `<div class="fond cinq"></div>`;
    }else if(piece == 6){
        preced.innerText = "🌷 Jardin souterrain 🌷";
        position.innerText = "💰 Chambre des trésors 💰";
        suiv.innerText = "☠️ Marais toxique ☠️";
        fond.innerHTML = `<div class="fond six"></div>`;
    }else if(piece == 7){
        preced.innerText = "💰 Chambre des trésors 💰";
        position.innerText = "☠️ Marais toxique ☠️";
        suiv.innerText = "👻 Cimetière hanté 👻";
        fond.innerHTML = `<div class="fond sept"></div>`;
    }else if(piece == 8){
        preced.innerText = "☠️ Marais toxique ☠️";
        position.innerText = "👻 Cimetière hanté 👻";
        suiv.innerText = "👹 Salle du boss 👹";
        fond.innerHTML = `<div class="fond huit"></div>`;
    }else if(piece == 9){
        preced.innerText = "👻 Cimetière hanté 👻";
        position.innerText = "👹 Salle du boss 👹";
        suiv.innerText = "🚪 Sortie 🚪";
        fond.innerHTML = `<div class="fond neuf"></div>`;
    }else if(piece == 10){
        preced.innerText = "👹 Salle du boss 👹";
        position.innerText = "🚪 Sortie 🚪";
        suiv.innerText = "🚪 Sortie 🚪";
        fond.innerHTML = `<div class="fond sortie"></div>`;
    }
}