<?php
require_once "../app/init.php";
require_once "../core/init.php";
session_start();
$app = new App();
$app->evaluarSearchRequest();
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
    <header id="header">
        <form action="" method="get">
            
                <div class="field has-addons">
                    <div class="control">
                        <input type="search" class="input" name="search" id="searchInput" placeholder="Buscar peticiones">
                    </div>
                    <div class="control">
                        <button class="button is-dark">
                        Search
                        </button>
                    </div>
              
            </div>
        </form>
    </header>
    <div class="contentMy">
        
        <?php  
            if (isset($_GET["petition"])){
                $app->mostrarPeticion(intval($_GET["petition"]));
            }
            else if (!$app->validarSesion()) {
                $app->renderNoProfile();
            }
            else if (isset($_GET) && isset($_GET["search"])){
                $app->busqueda($_GET["search"]);
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
    <script src="js/search.js"></script>
    <script src="js/themeVariableIcons.js"></script>

</body>
</html>