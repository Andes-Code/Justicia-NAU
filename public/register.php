<?php
if (isset($_POST) && isset($_POST["correo"]) && isset($_POST["nombreUsuario"]) && isset($_POST["psw"])){
    require_once "../app/init.php";
    require_once "../core/init.php";
    if (!isset($_POST["tyc"]))
    {
        print_r(json_encode([
            "status" => "error",
            "message" => "Debes aceptar los terminos y condiciones"
        ]));
        exit();
    }
    session_start();
    $app = new App();
    $tyc=1;
    $estatuto=intval($_POST["estatuto"]);
    $app->register($_POST["correo"],$_POST["nombreUsuario"],$_POST["psw"],$tyc,$estatuto);
}
else if (isset($_GET["correo"]) && count($_GET)==1)
{
    require_once "../app/init.php";
    require_once "../core/init.php";
    session_start();
    $app= new App();
    $app->register($_GET["correo"],"","",0,0,TRUE);
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.1/css/bulma.min.css">
    <link rel="stylesheet" href="./css/modifyIndexStyle.css">
    <!-- <link rel="stylesheet" href="./css/modifyRegisterStyle.css"> -->
    <link href="styles.css" rel="stylesheet">
    <link rel="manifest" href="./js/manifest.json">
    <script src="https://kit.fontawesome.com/e0fe908279.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

</head>
<body>
    <div class="formulario">
        <form id="form" class="form">
            <div class="field">
                <label for="correo" class="label">Correo eléctronico</label>
                <input type="email" class="input" name="correo" id="correo" placeholder="example@mail.com">
            </div>
            <div class="field">
                <label for="psw" class="label">Contraseña</label>
                <input type="password" class="input" name="psw" id="psw" placeholder="********">
            </div>
            <div class="field">
                <label for="nombreUsuario" class="label">Nombre de usuario</label>
                <input type="text" class="input" name="nombreUsuario" id="nombreUsuario" placeholder="Pepe Honguito">
            </div>
            <div class="field">
                <label for="terminos" class="label">Acepto los <a href="#">Términos y Condiciones</a></label>
                <input type="checkbox" name="tyc" id="tyc">
            </div>
            <div class="field form-link">
                <button type="button" class="button button-assistant is-link" id="register">registrarse</button>
            </div>
            <div class="field form-link">
                <a href="login.php">Ya tienes una cuenta? <strong>Inicia sesión</strong></a>
            </div>
            <input type="hidden" name="estatuto" id="estatuto-input" value="0">
        </form>
    </div>



    <!-- Main modal -->
    <div id="estatuto-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full flex bg-black opacity-50 backdrop-blur-sm">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-black">
                        Estatuto de la aplicacion
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="estatuto-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4">
                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                        estatuto parrafo 1
                    </p>
                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                        estatuto parrafo 2
                    </p>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button data-modal-hide="estatuto-modal" id="aceptar-estatuto" type="button" class="text-black bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Aceptar</button>
                    <button data-modal-hide="estatuto-modal" id="rechazar-estatuto" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Rechazar</button>
                </div>
            </div>
        </div>
    </div>

<script src="js/app.js"></script>
<!-- <script>
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
    document.getElementById("fileInput1").addEventListener('change', (event)=>{
        mostrarImagen(event,1)
    })  
</script>-->
</body>
</html>