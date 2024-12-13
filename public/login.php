<?php
require_once "../app/init.php";
require_once "../core/init.php";
session_start();
$app = new App();
$client = $app->getGoogleClient("login");
$authURL = $client->createAuthUrl();
$correo = "";
$psw = "";
$googleId = NULL;
if (isset($_POST) && isset($_POST["correo"]) && isset($_POST["psw"])){
    $correo=$_POST["correo"];
    $psw=$_POST["psw"];
    $app->login($correo,$psw,$googleId);
}else if (isset($_GET) && isset($_GET["authuser"])) {
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
        $psw = strval(random_int(0,10000000000));
        $googleId = $userInfo->id;
        $app->login($correo,$psw,$googleId);

        
        
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
$client=$app->getGoogleClient("login");
$authURL=$client->createAuthUrl();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moción NAU | Login</title>
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
    <header class="appName">
        <div class="grid align-center items-center backdrop-blur-s max-w-screen-xl text-center">
            <h1 class="-pt-10 text-3xl text-black font-black mt-4 mb-2" >Moción NAU</h1>
        </div>
    </header>
    <div class="formulario p-4">
        <form id="form" class="form max-w-sm mx-auto border-2 border-black border-dashed rounded-lg p-4">
        <h2 class="text-xl font-bold mb-5">Ingresá en tu cuenta</h2>
            <div class="field mb-5">
                <label for="correo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Correo eléctronico</label>
                <input type="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="correo" id="correo" placeholder="ejemplo@mail.com">                    
            </div>
            <div class="field mb-5">
                <label for="psw" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contraseña</label>
                <input type="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="psw" id="psw" placeholder="********">
            </div>
            <div class="field form-link mb-5">
                <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" id="login">Iniciar Sesión</button>
            </div>
            <div class="field form-link">
                <a href="register.php">No tienes una cuenta? <strong>Registrate</strong></a>
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
                    Iniciar sesion con Google
                    </button>
                </a>
            </div>
        </form>
    </div>

<script src="js/app.js"></script>
</body>
</html>