<form class="form" id="petition-form">
    <div id="etapa-1" class="visible"> 
        <div class="field give-top-margin-25">
            <label class="label">Título de la petición</label>
            <div class="control">
                <input class="input" type="text" name="titulo" id="titulo-input" maxlength="100" required placeholder="Ejemplo: Calles en mal estado en ...">
            </div>
        </div>
        <div class="field cuerpo give-top-margin-25">
            <label class="label">Cuerpo de la petición</label>
            <textarea class="textarea" name="cuerpo" id="cuerpo-input" required placeholder="Peticion..." rows="10"></textarea>
        </div>
        <div class="control button-assistant">
            <button type="button" class="button is-link" id="generate-text">Generar con ChatGPT</button>
        </div>
        <div class="control button-assistant give-top-margin-25">
            <!-- <button type="button" class="button is-primary is-light" id="create-petition">Siguiente</button> -->
            <button type="button" id="avanzar-1" class="button is-dark">Siguiente</button>
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
            <label class="label">Destino</label>
            <div class="control">
                <input type="text" class="input" id="destino-input" list="destino-opciones" name="destino" placeholder="(opcional)">
                <datalist id="destino-opciones"></datalist>
            </div>
        </div>
        <div class="field give-top-margin-25">
            <label class="label">Localidad</label>
            <div class="control">
                <input type="text" class="input" id="localidad-input" list="localidad-opciones" name="localidad" placeholder="(opcional)">
                <datalist id="localidad-opciones"></datalist>
            </div>
        </div>
        <div class="field has-addons">
            <div class="control button-assistant give-bottom-margin-10">
                <!-- <button type="button" class="button is-primary is-light" id="create-petition">Siguiente</button> -->
                <button type="button" id="volver-1" class="button is-black">Volver</button>
            </div>
            <div class="control button-assistant give-bottom-margin-10">
                <!-- <button type="button" class="button is-primary is-light" id="create-petition">Siguiente</button> -->
                <button type="button" id="avanzar-2" class="button is-dark">Siguiente</button>
            </div>
        </div>
    </div>
    <div id="etapa-3" class="hidden give-top-margin-25">
        <label class="label">Temáticas</label>
        <div class="field has-addons button-assistant form-tematicas">
            <div class="control">
                <input class="input" type="text" name="tematicas[]" list="tematica-opciones" id="tematica-input" placeholder="Ej.: Economia (opcional)">
                <datalist id="tematica-opciones"></datalist>
            </div>
            <div class="control">
                <button type="button" class="button is-link" id="boton-tematica">
                Añadir
                </button>
            </div>
        </div>
        <p class="help">Escribe el nombre de una temática y añádela cuando se autocomplete</p>
        <div class="field has-addons">
            <div class="control button-assistant give-bottom-margin-10">
                <!-- <button type="button" class="button is-primary is-light" id="create-petition">Siguiente</button> -->
                <button type="button" id="volver-2" class="button is-black">Volver</button>
            </div>
            <div class="control button-assistant give-bottom-margin-10">
                <!-- <button type="button" class="button is-primary is-light" id="create-petition">Siguiente</button> -->
                <button type="button" id="avanzar-3" class="button is-dark">Siguiente</button>
            </div>
        </div>
        <div class="field" id="caja-tematicas">
    
        </div>
    </div>
    <div id="etapa-4" class="hidden">
        <div class="field">

            <label class="label">Imágenes</label>
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
            <p class="help">Sube hasta cuatro imágenes que acompañen a tu petición</p>
        </div>
        
        <!-- <button type="button" id="uploadPetition" class="button">
            Subir Peticion
        </button> -->
        <div class="field has-addons">
            <div class="control button-assistant give-bottom-margin-10">
                <!-- <button type="button" class="button is-primary is-light" id="create-petition">Siguiente</button> -->
                <button type="button" id="volver-3" class="button is-black">Volver</button>
            </div>
            <div class="control button-assistant give-bottom-margin-10">
                <!-- <button type="button" class="button is-primary is-light" id="create-petition">Siguiente</button> -->
                <button type="button" id="create-petition" class="button is-link">Subir petición</button>
            </div>
        </div>
    </div>
</form>
