<?php
if (isset($_POST) && isset($_POST["correo"]) && isset($_POST["psw"])){
    require_once "../app/init.php";
    require_once "../core/init.php";
    session_start();
    $app = new App();
    $app->login($_POST["correo"],$_POST["psw"]);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
        </form>
    </div>

<script src="js/app.js"></script>
</body>
</html>