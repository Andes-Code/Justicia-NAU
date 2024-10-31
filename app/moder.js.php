<script>
    document.addEventListener('DOMContentLoaded', () => {
    async function editarPeticion(activador,estado,contenedor=".card") {
        const data = new FormData()
        data.append("peticion",activador.dataset.target)
        const response = await fetch("options.php?mode=admin&page="+estado,{
            method:"POST",
            body:data
        })
        const result = await response.json()
        if (result.status=="success"){
            alert(result.message)
            activador.closest(contenedor).remove()

        }
        
        console.log(result)
    }
    async function admitirTematica(boton,combinarCon='') {
        const data = new FormData()
        data.append("admitir",boton.dataset.target)
        if (combinarCon!='')
            data.append("combinarCon",combinarCon)
        const response = await fetch("options.php?mode=admin&page=tematicas",{
            method:"POST",
            body:data
        })
        const result = await response.json()
        console.log(result)
        if (result.status=="success")
        {
            window.location.reload()
        }
    }
    async function eliminarTematica(nombreTem) {
        const data = new FormData()
        data.append("eliminar",nombreTem)
        const response = await fetch("options.php?mode=admin&page=tematicas",{
            method:"POST",
            body:data
        })
        const result = await response.json()
        console.log(result)
        if (result.status=="success")
        {
            window.location.reload()
        }
    }
    async function agregarTematica() {
        const data = new FormData(document.getElementById("tematica-form"))
        
        const response = await fetch("options.php?mode=admin&page=tematicas",{
            method:"POST",
            body:data
        })
        const result = await response.json()
        console.log(result)
        if (result.status=="success")
        {
            alert("Tematica agregada")
            window.location.reload()
        }
        else if (result.status=="failed")
        {
            alert(result.message)
            if (result.inputError)
            {
                const input = document.getElementById(result.inputError)
                input.classList.add("is-danger")
                input.focus()
            }
        }
    }
    async function admitirDestino(boton,combinarCon='') {
        const data = new FormData()
        data.append("admitir",boton.dataset.target)
        if (combinarCon!='')
            data.append("combinarCon",combinarCon)
        const response = await fetch("options.php?mode=admin&page=destinos",{
            method:"POST",
            body:data
        })
        const result = await response.json()
        console.log(result)
        if (result.status=="success")
        {
            window.location.reload()
        }
    }
    async function eliminarDestino(nombreDest) {
        const data = new FormData()
        data.append("eliminar",nombreDest)
        const response = await fetch("options.php?mode=admin&page=destinos",{
            method:"POST",
            body:data
        })
        const result = await response.json()
        console.log(result)
        if (result.status=="success")
        {
            window.location.reload()
        }
    }
    async function agregarDestino() {
        const data = new FormData(document.getElementById("destino-form"))
        
        const response = await fetch("options.php?mode=admin&page=destinos",{
            method:"POST",
            body:data
        })
        const result = await response.json()
        console.log(result)
        if (result.status=="success")
        {
            alert("Destino agregado")
            window.location.reload()
        }
        else if (result.status=="failed")
        {
            alert(result.message)
            if (result.inputError)
            {
                const input = document.getElementById(result.inputError)
                input.classList.add("is-danger")
                input.focus()
            }
        }
    }
    async function admitirLocalidad(boton,combinarCon='') {
        const data = new FormData()
        data.append("admitir",boton.dataset.target)
        if (combinarCon!='')
            data.append("combinarCon",combinarCon)
        const response = await fetch("options.php?mode=admin&page=localidades",{
            method:"POST",
            body:data
        })
        const result = await response.json()
        console.log(result)
        if (result.status=="success")
        {
            window.location.reload()
        }
    }
    async function eliminarLocalidad(nombreLoc) {
        const data = new FormData()
        data.append("eliminar",nombreLoc)
        const response = await fetch("options.php?mode=admin&page=localidades",{
            method:"POST",
            body:data
        })
        const result = await response.json()
        console.log(result)
        if (result.status=="success")
        {
            window.location.reload()
        }
    }
    async function agregarLocalidad() {
        const data = new FormData(document.getElementById("localidad-form"))
        
        const response = await fetch("options.php?mode=admin&page=localidades",{
            method:"POST",
            body:data
        })
        const result = await response.json()
        console.log(result)
        if (result.status=="success")
        {
            alert("Localidad agregada")
            window.location.reload()
        }
        else if (result.status=="failed")
        {
            alert(result.message)
            if (result.inputError)
            {
                const input = document.getElementById(result.inputError)
                input.classList.add("is-danger")
                input.focus()
            }
        }
    }

    (document.querySelectorAll(".admitir") || []).forEach((boton)=>{
        boton.addEventListener("click",()=>{
            editarPeticion(boton,"alta")
        });
    });

    (document.querySelectorAll(".bajar") || []).forEach((boton)=>{
        boton.addEventListener("click",()=>{
            editarPeticion(boton,"baja")
        });
    });
    // (document.querySelectorAll(".generarPDF") || []).forEach((boton)=>{
    //     boton.addEventListener("click",()=>{
    //         editarPeticion(boton,"pdf")
    //     });
    // });
    (document.querySelectorAll(".admitir-tematica") || []).forEach((boton)=>{
        boton.addEventListener("click",()=>{
            admitirTematica(boton)
        });
    });
    (document.querySelectorAll(".combinar-tematica") || []).forEach((boton)=>{
        boton.addEventListener("click",()=>{
            modal=document.getElementById("visualizador-tematicas-existentes")
            modal.dataset.target=boton.dataset.target
            openModal(modal)
        });
    });
    (document.querySelectorAll(".eliminar-tematica") || []).forEach((boton)=>{
        boton.addEventListener("click",()=>{
            eliminarTematica(boton.dataset.target)
        });
    });
    (document.querySelectorAll(".confirmar-combinar-tematica") || []).forEach((boton)=>{
        boton.addEventListener("click",()=>{
            // admitirTematica(boton,(boton.closest(".modal").dataset.target))
            const admitir = boton.closest(".modal")
            admitirTematica(admitir,boton.dataset.target)

        });
    });
    (document.querySelectorAll(".admitir-destino") || []).forEach((boton)=>{
        boton.addEventListener("click",()=>{
            admitirDestino(boton)
        });
    });
    (document.querySelectorAll(".combinar-destino") || []).forEach((boton)=>{
        boton.addEventListener("click",()=>{
            modal=document.getElementById("visualizador-destinos-existentes")
            modal.dataset.target=boton.dataset.target
            openModal(modal)
        });
    });
    (document.querySelectorAll(".eliminar-destino") || []).forEach((boton)=>{
        boton.addEventListener("click",()=>{
            eliminarDestino(boton.dataset.target)
        });
    });
    (document.querySelectorAll(".confirmar-combinar-destino") || []).forEach((boton)=>{
        boton.addEventListener("click",()=>{
            // admitirDestino(boton,(boton.closest(".modal").dataset.target))
            const admitir = boton.closest(".modal")
            admitirDestino(admitir,boton.dataset.target)

        });
    });
    (document.querySelectorAll(".admitir-localidad") || []).forEach((boton)=>{
        boton.addEventListener("click",()=>{
            admitirLocalidad(boton)
        });
    });
    (document.querySelectorAll(".combinar-localidad") || []).forEach((boton)=>{
        boton.addEventListener("click",()=>{
            modal=document.getElementById("visualizador-localidades-existentes")
            modal.dataset.target=boton.dataset.target
            openModal(modal)
        });
    });
    (document.querySelectorAll(".eliminar-localidad") || []).forEach((boton)=>{
        boton.addEventListener("click",()=>{
            eliminarLocalidad(boton.dataset.target)
        });
    });
    (document.querySelectorAll(".confirmar-combinar-localidad") || []).forEach((boton)=>{
        boton.addEventListener("click",()=>{
            // admitirLocalidad(boton,(boton.closest(".modal").dataset.target))
            const admitir = boton.closest(".modal")
            admitirLocalidad(admitir,boton.dataset.target)

        });
    });
    const botonAddTematica = (document.getElementById("addTematica"))
    if (botonAddTematica)
    {
        botonAddTematica.addEventListener("click",()=>{agregarTematica()})
    }
    const botonAddDestino = (document.getElementById("addDestino"))
    if (botonAddDestino)
    {
        botonAddDestino.addEventListener("click",()=>{agregarDestino()})
    }
    const botonAddLocalidad = (document.getElementById("addLocalidad"))
    if (botonAddLocalidad)
    {
        botonAddLocalidad.addEventListener("click",()=>{agregarLocalidad()})
    }
    function openModal($el) {
      document.documentElement.classList.add("is-clipped")
      $el.classList.add('is-active');
    }
  
    function closeModal($el) {
      document.documentElement.classList.remove("is-clipped")
      $el.classList.remove('is-active');
    }

})
</script>