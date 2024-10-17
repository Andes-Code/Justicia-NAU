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

async function uploadPetition(botonPeticion){
    const formulario = new FormData(document.getElementById("petition-form"))
    const response = await fetch("./redact.php",{
        method:"POST",
        body:formulario
    })
    const result = await response.json()
    console.log("hola aqui")
    console.log(result)
    if (result.status=="success"){
        window.location.href = result.redirect
    }else if (result.status=="failed"){
        console.log(result)
        if (result.inputError){
            avanzar(result.etapa)
            alert(result.message)
            botonPeticion.disabled=false
            botonPeticion.classList.remove("is-loading")
            document.getElementById(result.inputError).focus()
        }
        else{
            alert(result.message)
            window.location.href=result.redirect
        }
    }
    // console.log(result)
}
// async function generateAIText(){
//  esta funcion sirve unicamente cuando se solicite a una api 
//     const texto = document.getElementById("cuerpo-input")
//     let data = new FormData()
//     data.append("cuerpo",texto.value)
//     data.append("get_data","")
//     let response = await fetch("./redact.php",{
//         method: "POST",
//         body: data
//     })
//     let result = await response.text()
//     console.log(result)
// }  
function mostrarImagen(event,nro) {
    const file = event.target.files[0];
    const previewImage = document.getElementById('previewImage'+nro);
    const plusSign = document.querySelector('.plus-sign'+nro);

    if (file) {
        const reader = new FileReader();

        reader.onload = function(e) {
            previewImage.src = e.target.result;
            previewImage.style.display = 'block';
            plusSign.style.display = 'none';
        };

        reader.readAsDataURL(file);
    } else {
        previewImage.style.display = 'none';
        plusSign.style.display = 'block';
    }
};
function avanzar(hacia) {
    const etapas = ["etapa-1", "etapa-2", "etapa-3", "etapa-4"];
    etapas.forEach((etapa, index) => {
        const elemento = document.getElementById(etapa);
        if (index + 1 === hacia) {
            elemento.classList.add("visible");
            elemento.classList.remove("hidden");
        } else {
            elemento.classList.add("hidden");
            elemento.classList.remove("visible");
        }
    });
}
 
function eliminar(tematica){
    document.getElementById(tematica).remove()
}
function addTematica(){
    const tematica = document.getElementById("tematica-input")
    if (!document.getElementById(tematica.value))
    {
        const form = document.getElementById("petition-form")
        const caja = document.getElementById("caja-tematicas")
        const boton = document.createElement("button")
        const input = document.createElement("input")
        boton.value = tematica.value
        boton.className = "button is-light"
        boton.innerHTML = tematica.value
        boton.type="button"
        boton.addEventListener("click",()=>{
            eliminar(boton.value)
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
}
const avanzar1 = document.getElementById("avanzar-1")
const avanzar2 = document.getElementById("avanzar-2")
const avanzar3 = document.getElementById("avanzar-3")
const volver1 = document.getElementById("volver-1")
const volver2 = document.getElementById("volver-2")
const volver3 = document.getElementById("volver-3")
// const botonIA = document.getElementById('generate-text')
const botonPeticion = document.getElementById('create-petition')
const destino = document.getElementById('destino-input')
const fileInput1 = document.getElementById('fileInput1')
const fileInput2 = document.getElementById('fileInput2')
const fileInput3 = document.getElementById('fileInput3')
const fileInput4 = document.getElementById('fileInput4')
const localidad = document.getElementById('localidad-input')
const tematica = document.getElementById('tematica-input')
let debounceTimeout;
// const peticion = document.getElementById('create-petition')

if (avanzar1){
    avanzar1.addEventListener("click",()=>{avanzar(2)})
}
if (avanzar2){
    avanzar2.addEventListener("click",()=>{avanzar(3)})
}
if (avanzar3){
    avanzar3.addEventListener("click",()=>{avanzar(4)})
}
if (volver1){
    volver1.addEventListener("click",()=>{avanzar(1)})
}
if (volver2){
    volver2.addEventListener("click",()=>{avanzar(2)})
}
if (volver3){
    volver3.addEventListener("click",()=>{avanzar(3)})
}
// if (botonIA){
//     botonIA.addEventListener("click", generateAIText)
// }
if (destino){
    destino.addEventListener('keyup', function() {
        clearTimeout(debounceTimeout);
        debounceTimeout = setTimeout(predict, 500, "destino"); // 300 ms de delay
    });
}
if (fileInput1){
    fileInput1.addEventListener('change', (event)=>{
        mostrarImagen(event,1)
    }) 
}
if (fileInput2){
    fileInput2.addEventListener('change', (event)=>{
        mostrarImagen(event,2)
    }) 
}
if (fileInput3){
    fileInput3.addEventListener('change', (event)=>{
        mostrarImagen(event,3)
    }) 
}
if (fileInput4){
    fileInput4.addEventListener('change', (event)=>{
        mostrarImagen(event,4)
    }) 
}
if (localidad){
    localidad.addEventListener('keyup', function() {
        clearTimeout(debounceTimeout);
        debounceTimeout = setTimeout(predict, 500, "localidad"); // 300 ms de delay
    });
}
if (botonPeticion){
    botonPeticion.addEventListener('click',()=>{
        botonPeticion.disabled=true
        botonPeticion.classList.add("is-loading")
        uploadPetition(botonPeticion)
    })
}
if (tematica){
    document.getElementById('boton-tematica').addEventListener('click',addTematica);
    tematica.addEventListener('keyup', function() {
        clearTimeout(debounceTimeout);
        debounceTimeout = setTimeout(predict, 500, "tematica"); // 300 ms de delay
    });
}
document.getElementById("petition-form").addEventListener("keypress",(e)=>{
    if (e.key=="Enter"){
        e.preventDefault()
    }
})
avanzar(1)
