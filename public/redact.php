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
    <title>Justicia NAU | Redactar petición</title>
    <!-- <link rel="stylesheet" href="./css/indexStyle.css"> -->
    <!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.1/css/bulma.min.css">
    <link rel="stylesheet" href="./css/modifyIndexStyle.css">-->
    <link href="styles.css" rel="stylesheet">
    <link rel="manifest" href="./js/manifest.json">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="contentMy p-4">
        <?php
            if ($sesionExiste){
                $app->renderFormularioPeticion();
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
    <script src="js/redact.js"></script>
    <script type="module" src="js/GeneradorTextoIA.js"></script>
    <script src="js/themeVariableIcons.js"></script>

</body>
</html>
