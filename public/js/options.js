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
    let debounceTimeout;
    const localidad = document.getElementById("localidad-input")

    const tematicaInput = document.getElementById('tematica-input')  
    const botonGuardarPref = document.getElementById("guardar-preferencias")
    if (botonGuardarPref){
        botonGuardarPref.addEventListener("click",()=>{
            botonGuardarPref.classList.add("is-loading")
            guardarPreferencias()
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
})