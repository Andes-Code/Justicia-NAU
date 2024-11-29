"use strict";
document.addEventListener('DOMContentLoaded', () => {
    let debounceTimeout;
    async function logTo(to, form = null) {
        let formulario;
        // Si no se proporciona un formulario, usa el del elemento con ID "form"
        if (form === null) {
            formulario = new FormData(document.getElementById("form"));
        } else {
            formulario = form;
        }
        // Realizar la solicitud fetch con los datos del formulario
        let response = await fetch(`./${to}.php`, {
            method: "POST",
            body: formulario
        });
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
            const modal=document.getElementById("estatuto-modal")
            modal.classList.remove("hidden")
            modal.ariaHidden="false"
            document.getElementById("cerrar-estatuto").addEventListener("click",()=>{
                modal.classList.add("hidden")
            })
            modal.addEventListener("click", (event) => {
                if (event.target === modal || event.target.classList.contains("opacity-50")) {
                    modal.classList.add("hidden")
                }
            });
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
    const urlParams = new URLSearchParams(window.location.search);
    const url = window.location.href.split("?")[0]
    let page = url.split("/")
    page = page[page.length-1]
    // Verificar si "google_auth" y "code" están presentes en la URL
    // console.log("Parametros de la URL:", urlParams);
    // register with google
    if (urlParams.has("code") && page=="register.php") {
        
        const code = urlParams.get("code");  // Obtiene el valor del parámetro 'code'
        // console.log("Valor de 'code':", code); // Imprime el valor de 'code'

        const formulario = new FormData();
        formulario.append("google_auth", 1);  // Indicar que es un registro con Google
        formulario.append("code", code);      // Agregar el 'code' al formulario
        formulario.append("tyc", 1); // Acuerdo con los términos y condiciones

        const modal = document.getElementById("estatuto-modal");
        if (modal) {
            modal.classList.remove("hidden");
            modal.setAttribute("aria-hidden", "false");

            // console.log("Modal visible:", modal);

            // Lógica para cerrar el modal
            document.getElementById("cerrar-estatuto").addEventListener("click", () => {
                window.location.href = "register.php"; // Redirige a la página de registro
            });

            modal.addEventListener("click", (event) => {
                if (event.target === modal || event.target.classList.contains("opacity-50")) {
                    modal.classList.add("hidden");
                    modal.setAttribute("aria-hidden", "true");
                }
            });

            // Aquí agregamos la lógica para aceptar o rechazar los términos

            document.getElementById("aceptar-estatuto").addEventListener("click", async () => {
                formulario.set("estatuto", 1); // Marca que el usuario aceptó
                logTo("register",formulario)
            });
            
            document.getElementById("rechazar-estatuto").addEventListener("click", async () => {
                formulario.set("estatuto", 0); // Marca que el usuario rechazó
                logTo("register", formulario);
            });
            
        } else {
            // console.error("Modal no encontrado en el DOM.");
        }
    } else {
        // console.log("Parámetro 'code' no encontrado en la URL.");
    }



})