document.addEventListener('DOMContentLoaded', () => {
    async function loadMoreSearch(boton) {
        boton.classList.add("is-loading")
        const contenedor = document.querySelector("#peticiones")
        const params = new URLSearchParams(window.location.search);
        const response = await fetch("search.php?search="+params.get("search")+"&limite="+(contenedor.childElementCount-1))
        const result = await response.json()
        // const btnLoadMore = modal.querySelector("#load-more-signs")
        // btnLoadMore.value=peticion
        // console.log(result)
        // return
        boton.classList.remove("is-loading")

        if (result.status=="no sesion")
            window.location.href=result.redirect
        else if (result.status=="success")
        {
        // lo anoto aca pero, acordarse de agregar usuarios y otros elementos a la busqueda
            const tempDiv=document.createElement("div")
            tempDiv.innerHTML=result.peticiones
            while (tempDiv.firstChild)
            {
                if (tempDiv.firstChild.nodeName === 'A') {
                    contenedor.appendChild(tempDiv.firstChild); // Mueve el div válido al contenedor
                } else {
                    tempDiv.removeChild(tempDiv.firstChild); // Elimina nodos no deseados
                }
            }
            // boton.classList.remove("is-loading")
            contenedor.appendChild(boton.closest(".load-more-div"))

        }
        else if (result.status=="wait") {
            boton.disabled=true
            boton.textContent=result.message
        }
    }
    const botonLoadMore=document.getElementById("load-more-search")
    if (botonLoadMore)
    {
        botonLoadMore.addEventListener("click",()=>{
            loadMoreSearch(botonLoadMore)
        })
    }


})