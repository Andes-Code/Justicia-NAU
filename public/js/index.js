document.addEventListener('DOMContentLoaded', () => {
    function actualizarFirmas(peticion,numero){
        const cantidad = document.getElementById("cantSpan"+peticion)
        const perc = document.getElementById("percSpan"+peticion)
        const obj = document.getElementById("objSpan"+peticion)
        const progresBar = document.getElementById("progress"+peticion)
        cant = parseInt(cantidad.innerHTML)+numero
        ob=parseInt(obj.innerHTML)
        cantidad.innerHTML = cant
        progresBar.value=cant
        perc.innerHTML = `${parseFloat(cant / ob * 100)}`.slice(0,4)+"%: "
    }
    async function firmar1(boton){
        const formulario = new FormData()
        formulario.append("firmar",boton.value)
        let response = await fetch("./index.php",{
            method: "POST",
            body: formulario
        })
        let result = await response.json()
        if(result.status=="wait"){
            const modal = document.getElementById("firma")
            document.getElementById("firmar").value=boton.value
            openModal(modal)
        }else if (result.status=="no sesion"){
            if (result.message)
            {
                let a = confirm(result.message)
                console.log(result)
                if (a)
                {
                    firmar1(boton)
                    return
                }
            }
            window.location.href=result.redirect
        }else if (result.status=="success"){
            boton.innerHTML="Firmar"
            boton.classList.add("is-dark")
            boton.classList.remove("is-danger")
            actualizarFirmas(boton.value,result.firmas)
        }
    }
    async function firmar2(){
        const formulario = new FormData(document.getElementById("form"))
        const firmar = document.getElementById("firmar")
        const boton = document.getElementById(`firmar${firmar.value}`);
        boton.classList.add("is-loading")
        let response = await fetch("./index.php",{
            method: "POST",
            body: formulario
        })
        let result = await response.json()
        if(result.status=="success"){
            document.getElementById("firma-comentario").value=""
            document.getElementsByName("anonimo").value=0
            closeModal(document.getElementById("firma"))
            boton.classList.add("is-danger")
            boton.classList.remove("is-dark")
            boton.classList.remove("is-loading")
            boton.innerHTML="Quitar firma"
            actualizarFirmas(firmar.value,result.firmas)
            firmar.value=""
        }
    }
    async function verFirmas(boton) {
        boton.classList.add("is-loading")
        peticion=boton.value
        const modal = document.getElementById("visualizador-firmas")
        const contenedor = document.getElementById("contenedor-firmas")
        const response = await fetch("index.php?verFirmas="+peticion+"&limite="+(contenedor.childElementCount-1))
        const result = await response.json()
        const btnLoadMore = modal.querySelector("#load-more-signs")
        btnLoadMore.value=peticion
        if (result.status=="no sesion")
            window.location.href=result.redirect
        else if (result.status=="success"){
            // console.log(result)
            boton.classList.remove("is-loading")
            wasOpen=true
            if (!(modal.classList.contains("is-active")))
            {
                openModal(modal)
                wasOpen=false
            }
            // console.log(result.firmas)
            // return
            insertarFirmas(contenedor,result.firmas)
            contenedor.appendChild(btnLoadMore.closest("div"))
            if (wasOpen && result.firmas.length==0)
            {
                boton.textContent="-"
                boton.disabled=true
            }
            // result.firmas.forEach((firma) => {
            //     // let a = document.createElement("div")
            //     // a.classList.add("box")
            //     // a.textContent=firma
            //     // contenedor.appendChild(a)
            //     contenedor.innerHTML+=firma
            // })
        }
    }
    function insertarFirmas(contenedor,firmas){
        const tempDiv=document.createElement("div")
        tempDiv.innerHTML=firmas
        // console.log(firmas)
        while (tempDiv.firstChild)
        {
            if (tempDiv.firstChild.nodeName === 'DIV') {
                contenedor.appendChild(tempDiv.firstChild); // Mueve el div válido al contenedor
            } else {
                tempDiv.removeChild(tempDiv.firstChild); // Elimina nodos no deseados
            }
        }
        // firmas.forEach((firma) => {
        //     // let a = document.createElement("div")
        //     // a.classList.add("box")
        //     // a.textContent=firma
        //     // contenedor.appendChild(a)
        //     contenedor.innerHTML+=firma
    }
    async function loadMorePets(boton) {
        boton.classList.add("is-loading")
        const container = document.querySelector('.contentMy');
        const postCount = container.querySelectorAll('.post').length;
        const response = await fetch("index.php?getPeticiones="+postCount)
        const result = await response.json()
        if (result.status=="no sesion")
        {
            window.location.href=result.redirect
        }
        else if (result.status=="success"){
            // boton.remove()
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = result.peticiones;
            (tempDiv.querySelectorAll('.sign') || []).forEach(($trigger) => {
                // const peticion = $trigger.value;
                $trigger.addEventListener('click', () => {
                    firmar1($trigger)
                });
            });
            (tempDiv.querySelectorAll('.view-signers') || []).forEach(($trigger) => {
                // const peticion = $trigger.value;
                $trigger.addEventListener('click', () => {
                    $trigger.classList.add("is-loading")
                    verFirmas($trigger)
                });
            });
            (tempDiv.querySelectorAll('.js-modal-trigger') || []).forEach(($trigger) => {
                const modal = $trigger.dataset.target;
                const $target = tempDiv.querySelector("#"+CSS.escape(modal));
            
                $trigger.addEventListener('click', () => {
                  openModal($target);
                });
              });
            
              // Add a click event on various child elements to close the parent modal
              (tempDiv.querySelectorAll('.modal-background, .modal-close, .modal-card-head .delete, .modal-card-foot .button') || []).forEach(($close) => {
                const $target = $close.closest('.modal');
                $close.addEventListener('click', () => {
                if ($target.id=="visualizador-firmas")
                {
                    (((document.getElementById("contenedor-firmas")).querySelectorAll(".box")) || []).forEach(firma => {
                        firma.remove()
                    });
                    botonLoadMore=document.getElementById("load-more-signs")
                    botonLoadMore.textContent="+"
                    botonLoadMore.disabled=false
                }
                closeModal($target);
                });
              });
            while (tempDiv.firstChild) {
                // Verifica si el primer hijo es un nodo de tipo 'DIV'
                if (tempDiv.firstChild.nodeName === 'DIV') {
                    container.appendChild(tempDiv.firstChild); // Mueve el div válido al contenedor
                } else {
                    tempDiv.removeChild(tempDiv.firstChild); // Elimina nodos no deseados
                }
            }
            boton.classList.remove("is-loading")
            container.appendChild(boton.closest(".is-centered"))
        }
        else if (result.status=="wait")
        {
            boton.classList.remove("is-loading")
            boton.textContent=result.message
        }
    }
    async function finalizarPeticion(peticion){
        let confirmar = confirm("Esta seguro que desea finalizar la peticion?")
        if (confirmar!=true)
            return
        const data = new FormData()
        data.append("nroPet",peticion.dataset.target)
        const response = await fetch("options.php?page=finalizar",{
            method: "POST",
            body: data
        })
        const result = await response.json()
        if (result.status=="success")
        {
            $trigger.closest(".card").remove()
            return true
        }
        return false

    }
    (document.querySelectorAll('.sign') || []).forEach(($trigger) => {
        // const peticion = $trigger.value;
        $trigger.addEventListener('click', () => {
            firmar1($trigger)
        });
    });
    (document.querySelectorAll('.finalizar') || []).forEach(($trigger) => {
        // const peticion = $trigger.value;
        $trigger.addEventListener('click', () => {
            finalizarPeticion($trigger)    
        });
    });
    (document.querySelectorAll('.view-signers') || []).forEach(($trigger) => {
        // const peticion = $trigger.value;
        $trigger.addEventListener('click', () => {
            // $trigger.classList.add("is-loading")
            verFirmas($trigger)
        });
    });
    const loadMorePetsBtn = document.getElementById("load-more")
    if (loadMorePetsBtn){
        loadMorePetsBtn.addEventListener("click",()=>{
            loadMorePets(loadMorePetsBtn)
        })
    }
    const loadMoreSignsBtn = document.getElementById("load-more-signs")
    if (loadMoreSignsBtn){
        loadMoreSignsBtn.addEventListener("click",()=>{
            verFirmas(loadMoreSignsBtn)
        })
    }
    document.getElementById("confirmar-firma").addEventListener("click",()=>{
        firmar2()
    })
    document.getElementById("cancelar-firma").addEventListener("click",()=>{
        closeModal(document.getElementById("firma"))
    })
    document.getElementById("visualizador-close").addEventListener("click",()=>{
        
        closeModal(document.getElementById("visualizador-firmas"))
    })
    
    function openModal($el) {
        $el.classList.add('is-active');
        document.documentElement.classList.add("is-clipped")
    }
    function closeModal($el) {
        $el.classList.remove('is-active');
        document.documentElement.classList.remove("is-clipped")
    }
    const tipoPeticion=document.getElementById('toggle-link')
    if (tipoPeticion)
    {
        tipoPeticion.addEventListener('click', function(event) {
            event.preventDefault(); // Evitar el comportamiento predeterminado del ancla
    
            const activas = document.getElementById('activas');
            const finalizadas = document.getElementById('finalizadas');
    
            // Alternar visibilidad
            if (finalizadas.classList.contains("visible")) {
                activas.classList.add("visible")
                activas.classList.remove("oculto")
                finalizadas.classList.add("oculto")
                finalizadas.classList.remove("visible")
                tipoPeticion.innerHTML="Ver finalizadas"
            } else {
                finalizadas.classList.add("visible")
                finalizadas.classList.remove("oculto")
                activas.classList.add("oculto")
                activas.classList.remove("visible")
                tipoPeticion.innerHTML="Ver activas"
            }
        });
    }
    
})