"use strict";
document.addEventListener('DOMContentLoaded', () => {
    let debounceTimeout;
    async function logTo(to){
        const formulario = new FormData(document.getElementById("form"))
        let response = await fetch("./"+to+".php",{
            method: "POST",
            body: formulario
        })
        let result = await response.json()
        console.log(result)
        if(result.status=="failed"){
            document.getElementById("estatuto-modal").classList.add("hidden")
            // alert(result.message)
        }
        if (result.message)
            alert(result.message)
        if(result.status=="error")
            document.getElementById("estatuto-modal").classList.add("hidden")
        if (result.inputError)
        {
            document.getElementById("estatuto-modal").classList.add("hidden")
            document.getElementById(result.inputError).focus()
            document.getElementById(result.inputError).classList.add("is-danger")
        }
        if (result.redirect) window.location.href=result.redirect
    }
    const form = document.getElementById("form")
    if (form){
        form.addEventListener("keypress",(e)=>{
            if (e.key=="Enter"){
                e.preventDefault()
            }
        })
    }
    
    const botonLogin = document.getElementById("login")
    const botonRegister = document.getElementById("register")
    const botonLogout = document.getElementById("logout")
    if (botonLogin){
        botonLogin.addEventListener("click",()=>{
            logTo("login")
        })
    }
    if (botonRegister){    
        botonRegister.addEventListener("click",() => {
            document.getElementById("estatuto-modal").classList.remove("hidden")
            document.getElementById("aceptar-estatuto").addEventListener("click",()=>{
                document.getElementById("estatuto-input").value=1
                logTo("register")
            })
            document.getElementById("rechazar-estatuto").addEventListener("click",()=>{
                document.getElementById("estatuto-input").value=0
                logTo("register")
            })
        })
    }
    if (botonLogout){
        botonLogout.addEventListener("click",async ()=>{
            let close = await fetch("logout.php")
            let result = await close.json()
            window.location.href=result.redirect
        })
    }
    let correo = document.getElementById("correo")
    if (correo && ((window.location.pathname.split("/")).pop())=="register.php"){
        correo.addEventListener('keyup', () => {
            clearTimeout(debounceTimeout);
            debounceTimeout = setTimeout(validarCorreo, 1000, correo); // 300 ms de delay
        });
    }
    async function validarCorreo(correo) {
        let response = await fetch("register.php?correo="+correo.value)
        let result = await response.json()
        console.log(result)
        if (result.email=="valid")
        {
            // correo.classList.remove("is-danger")
            correo.classList.add("is-primary")

        }
        else if (result.email=="used"){
            alert(result.message)
            correo.classList.add("is-danger")
        }
        
    }
    


})