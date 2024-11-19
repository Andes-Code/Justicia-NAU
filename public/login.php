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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.1/css/bulma.min.css">
    <link rel="stylesheet" href="./css/modifyIndexStyle.css">
</head>
<body>
    <div class="formulario box">
        <form id="form" class="form">
            <div class="field">
                <label for="correo" class="label">Correo eléctronico</label>
                <input type="email" class="input" name="correo" id="correo" placeholder="ejemplo@mail.com">                    
            </div>
            <div class="field">
                <label for="psw" class="label">Contraseña</label>
                <input type="password" class="input" name="psw" id="psw" placeholder="********">
            </div>
            <div class="field form-link">
                <button type="button" class="button button-assistant is-link" id="login">Iniciar Sesión</button>
            </div>
            <div class="field form-link">
                <a href="register.php">No tienes una cuenta? <strong>Registrate</strong></a>
            </div>
        </form>
    </div>

<script src="js/app.js"></script>
</body>
</html>