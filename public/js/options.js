document.addEventListener("DOMContentLoaded",()=>{
    async function predict(objeto){
        const texto=document.getElementById(`${objeto}-input`)
        let data = new FormData()
        data.append(objeto,texto.value)
        data.append("get_data",1)
        let response = await fetch("./redact.php",{
            method: "POST",
            body: data
        })
        let result = await response.json()
        // console.log(result);
        // tematica.value=result;
        const datalist = document.getElementById(`${objeto}-opciones`);
        // Limpiar las opciones anteriores
        datalist.innerHTML = '';
    
        // Añadir nuevas opciones
        result.forEach(item => {
            const option = document.createElement('option');
            option.value = item.nombre;
            option.innerHTML = item.nombre
            datalist.appendChild(option);
        });
    }
    async function cambiarImagen(imagen) {

        
    }
    function eliminarTematica(tematica){
        document.getElementById(tematica).remove()
    }
    function addTematica(){
        const tematica = document.getElementById("tematica-input")
        if (!document.getElementById(tematica.value))
            {
            const form = document.getElementById("preferencias-form")
            const caja = document.getElementById("caja-tematicas")
            const boton = document.createElement("button")
            const input = document.createElement("input")
            boton.value = tematica.value
            boton.className = "button is-light interes"
            boton.innerHTML = tematica.value
            boton.type="button"
            boton.addEventListener("click",()=>{
                eliminarTematica(boton.value)
                boton.remove()
            })
            input.value = tematica.value
            input.name = "tematicas[]"
            input.className = "input"
            input.type = "hidden"
            input.id = tematica.value
            caja.appendChild(boton)
            form.appendChild(input)
        }
        tematica.value=''
        tematica.focus()
    }
    async function guardarPreferencias() {
        const data = new FormData(document.getElementById("preferencias-form"))
        const response = await fetch("options.php?page=intereses",{
            method:"POST",
            body:data
        })
        const result = await response.json();
        console.log(result)
        if (result.status=="success")
        {
            window.location.href=result.redirect
        }
    }
    async function generarReporte() {
        const data = new FormData(document.getElementById("formulario-reporte"))
        const response = await fetch("options.php?page=reportes",{
            method:"POST",
            body:data
        })
        const result = await response.json();
        console.log(result)
        if (result.status=="success")
        {
            const content = document.querySelector(".contentMy2")
            // result.data.mes
            // result.data.cantidadPeticiones
            // result.data.cantidadPeticionesLocalidad
            // result.data.cantidadPeticionesTematica
            content.innerHTML=result.data
            // window.location.href=result.redirect
        }
        
    }
    let debounceTimeout;
    const localidad = document.getElementById("localidad-input")
    const botonReporte = document.getElementById("boton-reporte")
    const tematicaInput = document.getElementById('tematica-input')  
    const botonGuardarPref = document.getElementById("guardar-preferencias")
    const cambiarNombre = document.getElementById("cambiar-nombre-btn") 
    const cambiarFoto = document.getElementById("new-profileImg") 
    const eliminarFoto = document.getElementById("eliminar-imagen-btn") 
    if (botonGuardarPref){
        botonGuardarPref.addEventListener("click",()=>{
            botonGuardarPref.classList.add("is-loading")
            guardarPreferencias()
        })
    }
    if (cambiarNombre)
    {
        cambiarNombre.addEventListener("click",()=>{
            const confirmar = document.getElementById("confirmar-nombre-btn")
            const cancelar = document.getElementById("cancelar-nombre-btn")
            const input = document.getElementById("username-input")
            confirmar.classList.remove("oculto")
            cancelar.classList.remove("oculto")
            cambiarNombre.classList.add("oculto")
            input.disabled = false
            input.focus()
            confirmar.addEventListener("click",async ()=>{
                cancelar.disabled=true
                confirmar.disabled=true
                let conf = confirm("Seguro que desea establecer su nuevo nombre?")
                if (conf!=true)
                    return
                const data = new FormData()
                data.append("new-username",input.value)
                const response = await fetch("options.php?page=administrar_perfil",{
                    method: "POST",
                    body: data
                })
                const result = await response.json()
                if (result.status=="success")
                    window.location.reload()
                // console.log(result)
            })
            cancelar.addEventListener("click",()=>{
                confirmar.disabled=true
                // confirmar.classList.add("oculto")
                // cancelar.classList.add("oculto")
                // cambiarNombre.classList.remove("oculto")
                // input.disabled = false 
                window.location.reload()
            })
        })
    }
    if (eliminarFoto){
        eliminarFoto.addEventListener("click",async ()=>{
            let conf = confirm("Seguro que desea eliminar la foto?")
            if (conf!=true)
                return
            const data = new FormData()
            data.append("delete-image",1)
            const response = await fetch("options.php?page=administrar_perfil",{
                method: "POST",
                body: data
            })
            const result = await response.json()
            if (result.status=="success")
                window.location.reload()
        })

    }
    if (cambiarFoto){
        cambiarFoto.addEventListener("change",()=>{
            const cancelar = document.getElementById("cancelar-imagen-btn")
            const confirmar = document.getElementById("confirmar-imagen-btn")
            confirmar.classList.remove("oculto")
            cancelar.classList.remove("oculto")
            cancelar.addEventListener("click",()=>{
                window.location.reload()
            })
            confirmar.addEventListener("click",async ()=>{
                let conf = confirm("Seguro que desea continuar?")
                if (conf!=true)
                    return
                const archivo = cambiarFoto.files[0]; // Obtiene el archivo seleccionado
                if (archivo) {
                    const data = new FormData()
                    data.append("new-image", archivo);
                    const response = await fetch("options.php?page=administrar_perfil",{
                        method: "POST",
                        body: data
                    })
                    const result = await response.json()
                    if (result.status=="success")
                        window.location.reload()
                }
                else window.location.reload()
            })
        })
    }
    if (tematicaInput){
        let botonTematica=document.getElementById('boton-tematica')
        if (botonTematica)
            botonTematicaaddEventListener('click',addTematica);
        tematicaInput.addEventListener('keyup', function() {
            clearTimeout(debounceTimeout);
            debounceTimeout = setTimeout(predict, 500, "tematica"); // 300 ms de delay
        });
        (document.querySelectorAll(".interes") || []).forEach((boton)=>{
            boton.addEventListener("click",()=>{
                document.getElementById(boton.value).remove()
                boton.remove()
            })
        })
    }
    if (localidad){
        localidad.addEventListener('keyup', function() {
            clearTimeout(debounceTimeout);
            debounceTimeout = setTimeout(predict, 500, "localidad"); // 300 ms de delay
        });
    }
    if (botonReporte)
    {
        botonReporte.addEventListener("click",generarReporte)
    }
})