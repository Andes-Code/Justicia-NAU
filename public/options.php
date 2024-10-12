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
    <title>Proyecto Change</title>
    <!-- <link rel="stylesheet" href="./css/indexStyle.css"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.1/css/bulma.min.css">
    <link rel="stylesheet" href="./css/modifyIndexStyle.css">
</head>
<body>
    <div class="contentMy">
        <?php 
            $app->renderContenidoOptions();
            
        ?>
    </div>
    <footer id="my-footer">
        <div class="footer ">
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