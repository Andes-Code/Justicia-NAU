
<header id="header">
    <form class="informe" id="formulario-reporte">
        <div class="control">
            <label for="fecha">Ingrese los datos que desea consultar</label>
        </div>
        <div class="field has-addons" id="comparar">
            <div class="control">
                <input type="month" class="input" name="fecha" id="fechaInput">
            </div>
            <div class="control">
                <input list="tematica-opciones" type="text" class="input" name="tematica" id="tematica-input" placeholder="Tematica">
                <datalist id="tematica-opciones"></datalist>
            </div>
        </div>
        <div class="control">
            <input list="localidad-opciones"  id="localidad-input" type="text" class="input" name="localidad" placeholder="Escribe la ubicación..." />
            <datalist id="localidad-opciones"></datalist>       
        </div>
        <div class="control comparar-button-div">
            <button class="button is-dark comparar-button" type="button" id="boton-reporte">
            Consultar
            </button>
        </div>
    </form>
</header>
<div class="contentMy2">
</div>
<!-- activar cuando se cuente con una apikey de google -->
<!--script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places"></script-->
<script>
document.addEventListener("DOMContentLoaded",()=>{
    // const tematica = document.getElementById("tematica-input")
    function initAutocomplete() {
        const input = document.getElementById('localidad-input');
        const autocomplete = new google.maps.places.Autocomplete(input, {
            types: ['geocode'], // Puedes filtrar el tipo de lugar si solo necesitas ciudades.
            componentRestrictions: { country: 'ar' } // Opcional, restringir a un país.
        });

        autocomplete.addListener('place_changed', function() {
            const place = autocomplete.getPlace();
            if (place) {
                console.log("Nombre de la ubicación:", place.name);
                console.log("Dirección:", place.formatted_address);
                console.log("Coordenadas:", place.geometry.location.lat(), place.geometry.location.lng());
                // Puedes enviar estos datos a tu backend para guardarlos en la base de datos.
            }
        });
    }    
    
    // activar cuando se cuente con una apikey de google 
    // google.maps.event.addDomListener(window, 'load', initAutocomplete);
})
</script>
