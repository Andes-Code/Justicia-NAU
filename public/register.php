<?php
if (isset($_POST) && isset($_POST["correo"]) && isset($_POST["nombreUsuario"]) && isset($_POST["psw"])){
    require_once "../app/init.php";
    require_once "../core/init.php";
    session_start();
    $app = new App();
    $app->register($_POST["correo"],$_POST["nombreUsuario"],$_POST["psw"]);
}
else if (isset($_GET["correo"]) && count($_GET)==1)
{
    require_once "../app/init.php";
    require_once "../core/init.php";
    session_start();
    $app= new App();
    $app->register($_GET["correo"],"","",TRUE);
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
            <div class="field form-link">
                <button type="button" class="button button-assistant is-link" id="register">registrarse</button>
            </div>
            <div class="field form-link">
                <a href="login.php">Ya tienes una cuenta? <strong>Inicia sesión</strong></a>
            </div>
        </form>
    </div>

<script src="js/app.js"></script>
<script>
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
</script>
</body>
</html>