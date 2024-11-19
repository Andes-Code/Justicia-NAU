<?php
require_once "../app/init.php";
require_once "../core/init.php";
session_start();
$app = new App();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>Jusicia NAU | Perfil</title>
    <!-- <link rel="stylesheet" href="./css/indexStyle.css"> -->
    <link href="styles.css" rel="stylesheet">
    <link rel="manifest" href="./js/manifest.json">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <header class="appName">
        <div class="grid align-center items-center backdrop-blur-s max-w-screen-xl text-center">
            <h1 class="-pt-10 text-3xl text-black font-black mt-4 mb-2" >Justicia NAU</h1>
        </div>
    </header>
    <div class="contentMy">
    
        <?php
            if (isset($_GET) && isset($_GET["user"])){
                $app->renderProfile($_GET["user"]);
            }else if ($app->validarSesion()){
                $app->renderProfile($_SESSION["usuario"]->getUsuario()->getCorreo());
            }else{
                $app->renderNoProfile();
            }
        ?>
    </div>
    <footer id="footer" class='fixed bottom-0 left-0 w-full backdrop-blur-sm'>
        <div class="flex justify-around items-center py-2 backdrop-blur-sm">
            <?php $app->renderFooter(get_included_files()[0]) ?>
        </div>
        
    </footer>
    <?php 
    $app->renderTemplate("firma.php"); 
    $app->renderTemplate("firmas.php");
    if ($app->validarAdmin()) $app->loadModerJS();
    ?>
    <script src="js/bulma.js"></script>
    <script src="js/index.js"></script>
    <script src="js/themeVariableIcons.js"></script>

</body>
</html>