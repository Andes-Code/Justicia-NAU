<?php
require_once "../app/init.php";
require_once "../core/init.php";
session_start();
$app = new App();
$sesionExiste=TRUE;
if (!$app->validarSesion()){
    $sesionExiste=FALSE;
    // $app->renderNoProfile();
}else{
    $app->evaluarEstadoRedaccion();
    
}
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
    <link rel="stylesheet" href="./css/modifyRedactStyle.css">
    <link rel="manifest" href="./js/manifest.json">
</head>
<body>
    <div class="contentMy">
        <?php
            if ($sesionExiste){
                $app->renderFormularioPeticion();
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
    <script src="js/redact.js"></script>
    <script type="module" src="js/GeneradorTextoIA.js"></script>
    <script src="js/themeVariableIcons.js"></script>

</body>
</html>
