<?php
require_once "../app/init.php";
require_once "../core/init.php";
$app= new App();
session_start();
$client=$app->getGoogleClient("register");
$authURL=$client->createAuthUrl();
if ((isset($_POST) && isset($_POST["correo"]) && isset($_POST["nombreUsuario"]) && isset($_POST["psw"])) || (isset($_POST) && isset($_POST["google_auth"]) && isset($_POST["code"]) && isset($_POST["tyc"]) && isset($_POST["estatuto"]) && isset($_SESSION["google"]["mail"]) && isset($_SESSION["google"]["user"]) && isset($_SESSION["google"]["id"]))){
    if (!isset($_POST["tyc"]))
    {
        print_r(json_encode([
            "status" => "error",
            "message" => "Debes aceptar los terminos y condiciones"
        ]));
        exit();
    }
    $correo="";
    $nombreUsuario="";
    $id="";
    $psw="";
    if (isset($_POST["google_auth"])){
        // print_r(json_encode($_SESSION));
        // exit();
        $correo=$_SESSION["google"]["mail"];
        $nombreUsuario=$_SESSION["google"]["user"];
        $id=$_SESSION["google"]["id"];
        $psw=password_hash($correo.$nombreUsuario.$id.strval(rand(0,1000000000)),PASSWORD_DEFAULT);
        session_destroy();
    }else{
        $correo=$_POST["correo"];
        $nombreUsuario=$_POST["nombreUsuario"];
        $id=NULL;
        $psw=$_POST["psw"];
    }
    $tyc=1;
    $estatuto=intval($_POST["estatuto"]);
    $app->register($correo,$nombreUsuario,$psw,$tyc,$estatuto,$id);
}
else if (isset($_GET["correo"]) && count($_GET)==1)
{
    // Aqui se valida la disponibilidad del correo
    
    $app->register($_GET["correo"],"","",0,0,"",TRUE);
    exit();
}
// Manejo del inicio de sesión con Google
else if (isset($_GET["authuser"])) {
    // $client = getGoogleClient();

    // Si no hay código, redirigir a Google para autorización
    if (!isset($_GET["code"])) {
        // $authUrl = $client->createAuthUrl();
        header("Location: $authUrl");
        exit();
    }

    // Procesar el código de autorización de Google
    try {
        $token = $client->fetchAccessTokenWithAuthCode($_GET["code"]);
        if (isset($token['error'])) {
            throw new Exception('Error al obtener el token: ' . $token['error']);
        }

        $client->setAccessToken($token['access_token']);

        // Obtener información del usuario desde Google
        $oauth2 = new Google\Service\Oauth2($client);
        $userInfo = $oauth2->userinfo->get();

        // Enviar los datos a la lógica de registro o inicio de sesión
        $correo = $userInfo->email;
        $nombreUsuario = $userInfo->name;
        $googleId = $userInfo->id;
        
        // session_start();
        $_SESSION["google"]=[
            "mail"=>$correo,
            "user"=>$nombreUsuario,
            "id"=>$googleId
        ];
        
        // Registrar o iniciar sesión con Google
        // $app->register($correo, $nombreUsuario, '', 1, 0);

        // Redirigir al usuario o mostrar un mensaje
        // echo json_encode([
        //     "status" => "success",
        //     "message" => "Inicio de sesión exitoso con Google",
        //     "user" => [
        //         "correo" => $correo,
        //         "nombreUsuario" => $nombreUsuario
        //     ]
        // ]);
    } catch (Exception $e) {
        echo json_encode([
            "status" => "error",
            "message" => $e->getMessage()
        ]);
        exit();
    }
}
// $client=$app->getGoogleClient();
// $authURL=$client->createAuthUrl();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moción NAU | Registrarse</title>
    <!-- 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.1/css/bulma.min.css">
    <link rel="stylesheet" href="./css/modifyIndexStyle.css">
    <link rel="stylesheet" href="./css/modifyRegisterStyle.css"> -->
    <link href="styles.css" rel="stylesheet">
    <link rel="manifest" href="./js/manifest.json">
    <script src="https://kit.fontawesome.com/e0fe908279.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

</head>
<body>
    <div class="formulario p-4">
        <form id="form" class="form max-w-sm mx-auto border-2 border-black border-dashed rounded-lg p-4">
        <h2 class="text-xl font-bold mb-5">Creá tu cuenta gratuita</h2>
            <div class="field mb-5">
                <label for="correo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">E-Mail</label>
                <input type="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="correo" id="correo" placeholder="anthonydiaz@mail.com">
            </div>
            <div class="field mb-5">
                <label for="psw" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contraseña</label>
                <input type="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="psw" id="psw" placeholder="********">
            </div>
            <div class="field mb-5">
                <label for="nombreUsuario" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre de usuario</label>
                <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="nombreUsuario" id="nombreUsuario" placeholder="Antonio Díaz">
            </div>
            <div class="flex items-start mb-5">
                <div class="flex items-center h-5">
                <input type="checkbox" name="tyc" id="tyc" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800">
                </div>
                <label for="terminos" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Acepto los <a href="#"><b>Términos y Condiciones</b></a></label>
            </div>
            <div class="field form-link mb-5">
                <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" id="register">Registrarse</button>
            </div>
            <div class="field form-link">
                <a href="login.php">Ya tienes una cuenta? <strong>Inicia sesión</strong></a>
            </div>
            <div class="field form-link">
                <a href="<?php echo $authURL?>">
                    <button class="cursor-pointer text-black flex gap-2 items-center bg-white px-4 py-2 rounded-lg font-medium text-sm hover:bg-zinc-300 transition-all ease-in duration-200" type="button">
                    <svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg" class="w-6">
                        <path
                        d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"
                        fill="#FFC107"
                        ></path>
                        <path
                        d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"
                        fill="#FF3D00"
                        ></path>
                        <path
                        d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"
                        fill="#4CAF50"
                        ></path>
                        <path
                        d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"
                        fill="#1976D2"
                        ></path>
                    </svg>
                    Registrate con Google
                    </button>
                </a>
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
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" id="cerrar-estatuto">
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