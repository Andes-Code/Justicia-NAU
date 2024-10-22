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
    <script src="https://kit.fontawesome.com/e0fe908279.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <header class="appName">
        <div>
            <a href="./index.php">
                <h1 class="title is-5">Justicia NAU</h1>
            </a>
        </div>
    </header>
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