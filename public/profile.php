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
    <title>Proyecto Change</title>
    <!-- <link rel="stylesheet" href="./css/indexStyle.css"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.1/css/bulma.min.css">
    <link rel="stylesheet" href="./css/modifyIndexStyle.css">
    <link rel="manifest" href="./js/manifest.json">
</head>
<body>
    <header class="appName">
        <div>
            Proyecto Change
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
    <footer id="my-footer">
        <div class="footer ">
            <?php $app->renderFooter(get_included_files()[0]) ?>
        </div>
    </footer>
    <?php $app->renderTemplate("firma.php") ?>
    <?php $app->renderTemplate("firmas.php") ?>
    <script src="js/bulma.js"></script>
    <script src="js/index.js"></script>
    <script src="js/themeVariableIcons.js"></script>

</body>
</html>