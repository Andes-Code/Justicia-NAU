import { MLCEngine } from "https://esm.run/@mlc-ai/web-llm";
document.addEventListener('DOMContentLoaded', () => {
    async function generateAIText(boton){

        const texto = document.getElementById("cuerpo-input")
        const selectedModel = "Llama-3-8B-Instruct-q4f32_1-MLC";
        const engine = new MLCEngine();
        engine.setInitProgressCallback(console.info);
        await engine.reload(selectedModel);
        const messages = [ 
            { role: "system", content: "Genera un texto pseudo formal basado en lo que te pasen. El texto debe tener entre 150 y 400 caracteres. No añadas comentarios ni aclaraciones extra, ni agregues zonas para poner nombres ni saludos, asuntos, frases descriptivas de lo que esta escrito ni nada, solamente escribe el texto" }, 
            { role: "user", content: texto.value }
        ];
        botonIA.textContent="Ya casi terminamos"
        botonIA.classList.remove("is-loading")
        setTimeout(()=>{
            botonIA.classList.add("is-loading")
        },4000)
        const reply = await engine.chat.completions.create({ messages });
        const textoFormal = reply.choices[0].message;
        console.log(textoFormal)
        texto.value=textoFormal.content

        botonIA.textContent="¡Listo!"
        botonIA.classList.remove("is-loading")
        botonIA.disabled=false
        setTimeout(()=>{
            botonIA.textContent="Generar con ChatGPT"
        },2000)
    }  
    const botonIA = document.getElementById('generate-text')
    if (botonIA){
        botonIA.addEventListener("click",()=>{
            botonIA.disabled=true
            const respaldo = botonIA.textContent
            botonIA.textContent="Esto puede tomar unos minutos"
            setTimeout(()=>{
                botonIA.classList.add("is-loading")
            },2000)
            generateAIText(botonIA)
        })
    }
})