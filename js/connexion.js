
let btnMdpConnect = document.getElementById("btnMdpConnect");
let mdpConnect = document.getElementById("mdp_connexion");

btnMdpConnect.addEventListener("click", (e) => {
    if(mdpConnect.type === "password"){
        mdpConnect.type = "text";
    }else{
        mdpConnect.type = "password";
    }
})

