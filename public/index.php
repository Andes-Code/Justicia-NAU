<?php
require_once "../app/init.php";
require_once "../core/init.php";
session_start();
$app = new App();
$app->evaluarIndexRequest();

?>

<!DOCTYPE html>
<html lang="en" class="">
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
        <div>proyecto change</div>
    </header>
    <!-- <header>
        <input type="search" name="search" id="searchInput" placeholder="Buscar peticiones">
    </header> -->
    <div class="contentMy">
        <?php $app->displayPetitions(0) ?>
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