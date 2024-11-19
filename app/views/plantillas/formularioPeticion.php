<form class="max-w-sm mx-auto p-8" id="petition-form">
    <div id="etapa-1" class="visible"> 
        <div>
            <label class="block mb-2 text-xl font-bold text-gray dark:text-white">Título de la petición</label>
            <div class="control">
                <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="text" name="titulo" id="titulo-input" maxlength="100" required placeholder="Ejemplo: Calles en mal estado en ...">
            </div>
        </div>
        <div class="field cuerpo mt-8">
            <label class="block mb-2 text-xl font-bold text-gray dark:text-white">Cuerpo de la petición</label>
            <textarea class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="cuerpo" id="cuerpo-input" required placeholder="Peticion..." rows="10"></textarea>
        </div>
        <!--
        <div class="control button-assistant">
            <button type="button" class="button is-link" id="generate-text">Generar con ChatGPT</button>
        </div> -->
        <div class="mt-8 control button-assistant give-top-margin-25">
            <!-- <button type="button" class="button is-primary is-light" id="create-petition">Siguiente</button> -->
            <button type="button" id="avanzar-1" class="text-white bg-red hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Siguiente</button>
        </div>
    </div>
    <div id="etapa-2" class="hidden">
        <!-- <div class="field give-top-margin-25">
            <label class="label">Objetivo de firmas</label>
            <div class="control">
                <input type="number" class="input" id="objetivo-input" name="objetivo" placeholder="El objetivo de firmas debe ser mayor a 100">
            </div>
        </div> -->
        <div class="field give-top-margin-25">
            <label class="block mb-2 text-xl font-bold text-gray dark:text-white">Destino</label>
            <div class="control">
                <input type="text" class="mb-8 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" id="destino-input" list="destino-opciones" name="destino" placeholder="(opcional)">
                <datalist id="destino-opciones"></datalist>
            </div>
        </div>
        <div class="field give-top-margin-25">
            <label class="block mb-2 text-xl font-bold text-gray dark:text-white">Localidad</label>
            <div class="control">
                <input type="text" class="mb-8 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" id="localidad-input" list="localidad-opciones" name="localidad" placeholder="(opcional)">
                <datalist id="localidad-opciones"></datalist>
            </div>
        </div>
        <div class="field has-addons">
            <div class='grid grid-cols-2 justify-items-center'>
            <div class="control button-assistant give-bottom-margin-10">
                <!-- <button type="button" class="button is-primary is-light" id="create-petition">Siguiente</button> -->
                <button type="button" id="volver-1" class="text-white bg-gray-light hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 w-36">Volver</button>
            </div>
            <div class="control button-assistant give-bottom-margin-10">
                <!-- <button type="button" class="button is-primary is-light" id="create-petition">Siguiente</button> -->
                <button type="button" id="avanzar-2" class="text-white bg-red hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 w-36">Siguiente</button>
            </div>
            </div>
        </div>
    </div>
    <div id="etapa-3" class="hidden give-top-margin-25">
        <label class="block mb-2 text-xl font-bold text-gray dark:text-white">Temáticas</label>
        <div class="field has-addons button-assistant form-tematicas">
            <div class='grid grid-cols-2 justify-items-center'>
            <div class="control">
                <input class="mb-8 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="text" name="tematicas[]" list="tematica-opciones" id="tematica-input" placeholder="Ej.: Salud (opcional)">
                <datalist id="tematica-opciones"></datalist>
            </div>
            <div class="control">
                <button type="button" class="text-white bg-red hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 w-28" id="boton-tematica">
                Añadir
                </button>
            </div>
            </div>
        </div>
        <p class="-mt-4 mb-8 text-xs text-gray-light">Escribe el nombre de una temática y añádela cuando se autocomplete</p>
        <div class="field mt-8 grid grid-cols-4 space-x-2 justify-items-center text-xs text-wrap" id="caja-tematicas">
    
        </div>
        <div class=" field has-addons">
            <div class='mt-8 grid grid-cols-2 justify-items-center'>
            <div class="control button-assistant give-bottom-margin-10">
                <!-- <button type="button" class="button is-primary is-light" id="create-petition">Siguiente</button> -->
                <button type="button" id="volver-2" class="text-white bg-gray-light hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 w-32">Volver</button>
            </div>
            <div class="control button-assistant give-bottom-margin-10">
                <!-- <button type="button" class="button is-primary is-light" id="create-petition">Siguiente</button> -->
                <button type="button" id="avanzar-3" class="text-white bg-red hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 w-32">Siguiente</button>
            </div>
            </div>
        </div>
    </div>
    <div id="etapa-4" class="hidden">
        <div class="field">

            <label class=" block mb-8 text-xl font-bold text-gray dark:text-white">Imágenes</label>
            
            
<div class="flex items-center justify-center w-full file-upload">
    <label for="dropzone-file" class="mb-8 flex flex-col items-center justify-center w-full h-64 border-2 border-gray-light border-dashed rounded-lg cursor-pointer bg-gray-xlight dark:hover:bg-gray dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
        <div class="flex flex-col items-center justify-center pt-5 pb-6">
            <svg class="w-8 h-8 mb-4 text-gray-light dark:text-gray-light" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
            </svg>
            <p class="mb-2 text-sm text-gray-light dark:text-gray-light"><span class="font-semibold">Click para subir</span> o arrastra y suelta (máx 4)</p>
            <p class="text-xs text-gray-light dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
        </div>
        <input id="dropzone-file" type="file" class="hidden" name="imagenes[]" accept="image/*" />
    </label>
</div> 

            
<!-- antiguo file upload 
            <div class="file-upload">
                <div>
                    <input type="file" id="fileInput1" class="file fileInput" name="imagenes[]" accept="image/*">
                    <label for="fileInput1" class="custom-file-label">
                        <span class="plus-sign plus-sign1">+</span>
                        <img id="previewImage1" src="" alt="Image preview" style="display: none;">
                    </label>
                </div>    
                <div>
                    <input type="file" id="fileInput2" class="file fileInput" name="imagenes[]" accept="image/*">
                    <label for="fileInput2" class="custom-file-label">
                        <span class="plus-sign plus-sign2">+</span>
                        <img id="previewImage2" src="" alt="Image preview" style="display: none;">
                    </label>
                </div>    
                <div>
                    <input type="file" id="fileInput3" class="file fileInput" name="imagenes[]" accept="image/*">
                    <label for="fileInput3" class="custom-file-label">
                        <span class="plus-sign plus-sign3">+</span>
                        <img id="previewImage3" src="" alt="Image preview" style="display: none;">
                    </label>
                </div>    
                <div>
                    <input type="file" id="fileInput4" class="file fileInput" name="imagenes[]" accept="image/*">
                    <label for="fileInput4" class="custom-file-label">
                        <span class="plus-sign plus-sign4">+</span>
                        <img id="previewImage4" src="" alt="Image preview" style="display: none;">
                    </label>
                </div>    
            </div>
            
            <p class="help">Sube hasta cuatro imágenes que acompañen a tu petición</p>-->
        </div>
        
        <!-- <button type="button" id="uploadPetition" class="button">
            Subir Peticion
        </button> -->
        <div class="field has-addons">
            <div class='mt-8 grid grid-cols-2 justify-items-center'>
            <div class="control button-assistant give-bottom-margin-10">
                <!-- <button type="button" class="button is-primary is-light" id="create-petition">Siguiente</button> -->
                <button type="button" id="volver-3" class="text-white bg-gray-light hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 w-32">Volver</button>
            </div>
            <div class="control button-assistant give-bottom-margin-10">
                <!-- <button type="button" class="button is-primary is-light" id="create-petition">Siguiente</button> -->
                <button type="button" id="create-petition" class="text-white bg-red hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 w-32">Subir petición</button>
            </div>
            </div>
        </div>
    </div>
</form>
