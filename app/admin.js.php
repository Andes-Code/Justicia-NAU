<script>
document.addEventListener('DOMContentLoaded', () => {
    async function search(boton) {
        boton.classList.add("is-loading")
        const contenedor = document.querySelector(".contentMy2")
        const busqueda = document.getElementById("searchInput")
        const response = await fetch("options.php?mode=admin&page=usuarios&search="+busqueda.value)
        const result = await response.json()
        boton.classList.remove("is-loading")

        if (result.status=="no sesion")
            window.location.href=result.redirect
        else if (result.status=="success")
        {
        // lo anoto aca pero, acordarse de agregar usuarios y otros elementos a la busqueda
            const tempDiv=document.createElement("div")
            tempDiv.innerHTML=result.usuarios
            contenedor.innerHTML=""
            while (tempDiv.firstChild)
            {
                if (tempDiv.firstChild.nodeName === 'DIV') {
                    contenedor.appendChild(tempDiv.firstChild); // Mueve el div válido al contenedor
                } else {
                    tempDiv.removeChild(tempDiv.firstChild); // Elimina nodos no deseados
                }
            }
            (document.querySelectorAll(".give-moder") || []).forEach((boton)=>{
                boton.addEventListener("click",()=>{
                    give("moderador",boton.dataset.target)
                })
            });
            (document.querySelectorAll(".give-admin") || []).forEach((boton)=>{
                boton.addEventListener("click",()=>{
                    give("admin",boton.dataset.target)
                })
            });
            (document.querySelectorAll(".give-user") || []).forEach((boton)=>{
                boton.addEventListener("click",()=>{
                    give("user",boton.dataset.target)
                })
            });
        }
    }

    async function generarInforme() {
        const params = new URLSearchParams(window.location.search);
        const opcion = params.get("opcion")
        let result = null
        if (opcion=="mensual" || opcion=="anual")
        {
            const mes = document.getElementById("fechaInput")
            if (mes.value=='')
            {
                alert("Debe ingresar una fecha valida")
                mes.focus()
                return
            }
            const request = await fetch(window.location.href+"&fecha1="+mes.value) 
            result = await request.json()
        }
        else if (opcion=="comparar")
        {
            const mes = document.getElementById("fechaInput1")
            const mes2 = document.getElementById("fechaInput2")
            if (mes.value=='')
            {
                alert("Debe ingresar una fecha valida")
                mes.focus()
                return
            }
            if (mes2.value=='')
            {
                alert("Debe ingresar una fecha valida")
                mes2.focus()
                return
            }
            const request = await fetch(window.location.href+"&fecha1="+mes.value+"&fecha2="+mes2.value) 
            result = await request.json()
        }
        if (result.status=="error")
        {
            alert(result.message)
            if (result.inputError)
                document.getElementById(result.inputError).focus()   
            return
        }
        const contenido = document.querySelector(".contentMy2")
        contenido.innerHTML=result.result
        console.log(result)

        
        
    }
    async function archivar(peticion) {
        let confirmar = confirm("Seguro que desea archivar peticion n°"+peticion.dataset.target+"?")
        if (confirmar!=true)
            return
        const data = new FormData()
        data.append("peticion",peticion.dataset.target)
        const response = await fetch("options.php?mode=admin&page=peticiones_finalizadas&option=archivar",{
            method:"POST",
            body:data
        })
        const result = await response.json()
        if (result.status=="success")
        {
            alert("Peticion archivada")
            peticion.closest(".card").remove()
        }
    }
    async function give(rol,correo) {
        const data = new FormData()
        data.append("rol",rol)
        data.append("correo",correo)
        const response = await fetch("options.php?mode=admin&page=usuarios",{
            method:"POST",
            body:data
        })
        const result = await response.json()
        if (result.status=="success")
        {
            alert("Rol cambiado")
            window.location.reload()
        }
        console.log(result)
    }
    const botonSearch=document.getElementById("searchUsuario")
    const botonInforme=document.getElementById("searchInforme")
    
    if (botonSearch)
    {
        botonSearch.addEventListener("click",()=>{
            search(botonSearch)
        })
    }
    if (botonInforme)
    {
        botonInforme.addEventListener("click",()=>{
            generarInforme()
        })
    }
    (document.querySelectorAll(".archivar") || []).forEach((boton)=>{
        boton.addEventListener("click",()=>{
            archivar(boton)
        });
    });


})
</script>