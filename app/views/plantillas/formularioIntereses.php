<div id="div-preferencias" class="give-top-margin-25">
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
    <p class="help">Escribe el nombre de una temática que sea de tu interes y añádela cuando se autocomplete. Puedes elegir hasta 5 temáticas</p>
    <div class="field has-addons">
        <div class="control button-assistant give-bottom-margin-10">
            <!-- <button type="button" class="button is-primary is-light" id="create-petition">Siguiente</button> -->
            <button type="button" id="cancelar" class="button is-black"><a href="options.php" class="search-link">Cancelar</a></button>
        </div>
        <div class="control button-assistant give-bottom-margin-10">
            <!-- <button type="button" class="button is-primary is-light" id="create-petition">Siguiente</button> -->
            <button type="button" id="guardar-preferencias" class="button is-dark">Guardar</button>
        </div>
    </div>
</div>