let btnMdpCrea = document.getElementById("btnMdpCrea");
let mdpCrea = document.getElementById("mdp_creation");
let btnMdpVerif = document.getElementById("btnMdpVerif");
let mdpVerif = document.getElementById("mdpVerif_creation");

btnMdpCrea.addEventListener("click", (e) => {
    if(mdpCrea.type === "password"){
        mdpCrea.type = "text";
    }else{
        mdpCrea.type = "password";
    }
})

btnMdpVerif.addEventListener("click", (e) => {
    if(mdpVerif.type === "password"){
        mdpVerif.type = "text";
    }else{
        mdpVerif.type = "password";
    }
})