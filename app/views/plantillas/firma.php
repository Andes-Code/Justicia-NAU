<div class="modal" id="firma">
	<div class="modal-background"></div>
	<div class="modal-content">
		<div class='formulario'>
		<form id='form' class='form'>
			<div class='field'>
				<label for='comentario' class='label'>Comentario</label>
				<textarea type='textarea' class='textarea' name='comentario' id='firma-comentario' placeholder='Comenta por que estas de acuerdo con esta petición' rows='3'></textarea>
			</div>
			<div class="field">
				<div class='checkbox-new'>
					<label for='anonimo' class='checkbox'>
					Deseas que tu firma sea anonima?
					</label>
					<div class="control">
						<label class="radio">
							<input type="radio" name="anonimo" value="1"/>
							<span>Si</span>
						</label>
						<label class="radio">
							<input type="radio" name="anonimo" value="0"checked/>
							<span>No</span>
						</label>
					</div>
					
				</div>
				
			</div>
			<div class="field has-addons give-top-margin-25">
				<div class="control button-assistant give-bottom-margin-10">
					<button type="button" id="cancelar-firma" class="button is-black">Cancelar</button>
				</div>
				<div class="control button-assistant give-bottom-margin-10">
					<button type="button" id="confirmar-firma" class="button is-primary">Firmar petición</button>
				</div>
			</div>
            <input type="hidden" name="firmar" id="firmar">
		</form>
		</div>
	</div>
	<button class="modal-close is-large" aria-label="close"></button>
</div>