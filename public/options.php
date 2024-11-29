<?php
require_once "../app/init.php";
require_once "../core/init.php";
session_start();
$app = new App();
$app->validarOptionsRequest();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>Moción NAU | Opciónes</title>
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
            <h1 class="-pt-10 text-3xl text-black font-black mt-4 mb-2" >Moción NAU</h1>
        </div>
    </header>
    <div class="contentMy flex flex-col p-4">
        <?php 
            $app->renderContenidoOptions();
            
        ?>
    </div>
    <div class="w-full h-[50px]"></div>
    <footer id="footer" class='fixed bottom-0 left-0 w-full backdrop-blur-sm'>
        <div class="flex justify-around items-center py-2 backdrop-blur-sm">
            <?php $app->renderFooter(get_included_files()[0]) ?>
        </div>
        
    </footer>
    <script src="js/app.js"></script>
    <script src="js/bulma.js"></script>
    <script src="js/options.js"></script>
    <script src="js/themeVariableIcons.js"></script>
    <?php
     if ($app->validarAdmin()) $app->loadAdminJS();
     if ($app->validarModer()) $app->loadModerJS();
    ?>
    

</body>
</html>