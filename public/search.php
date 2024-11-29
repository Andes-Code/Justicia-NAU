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
    <title>Justicia NAU | Búsqueda</title>
    <!-- <link rel="stylesheet" href="./css/indexStyle.css"> -->
    <!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.1/css/bulma.min.css">
    <link rel="stylesheet" href="./css/modifyIndexStyle.css"> -->
    <link href="styles.css" rel="stylesheet">
    <link rel="manifest" href="./js/manifest.json">
    <script src="https://kit.fontawesome.com/e0fe908279.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

</head>
<body class='p-4'>
        <div class="grid align-center items-center backdrop-blur-s max-w-screen-xl text-center">
            <h1 class="-pt-10 text-3xl text-black font-black mt-4 mb-2" >Moción NAU</h1>
        </div>
    <header id="header" class="mb-4">
        <!-- nueva barra de busqueda -->

        
        <form action="" method="get" class="max-w-md mx-auto">   
            <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input type="search" id="searchInput" name="search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Buscar peticiones..." required />
                <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-red hover:bg-red focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Buscar</button>
            </div>
        </form>


        <!-- vieja barra de busqueda 
        <form action="" method="get">
            
                <div class="field has-addons">
                    <div class="control">
                        <input type="search" class="input" name="search" id="searchInput" placeholder="Buscar peticiones">
                    </div>
                    <div class="control">
                        <button class="button is-dark">
                        <span class="icon is-small is-right">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                        </button>
                    </div>
              
                </div>
        </form>
        -->
    </header>
    <div class="m-2 mt-4 mb-8" id='peticiones'>
        
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
    <footer id="footer" class='fixed bottom-0 left-0 w-full backdrop-blur-sm'>
        <div class="flex justify-around items-center py-2 backdrop-blur-sm">
            <?php $app->renderFooter(get_included_files()[0]) ?>
        </div>
        
    </footer>
    <?php $app->renderTemplate("firma.php") ?>
    <?php $app->renderTemplate("firmas.php") ?>
    
    <!-- <script src="js/bulma.js"></script> -->
    <script src="js/index.js"></script>
    <script src="js/search.js"></script>
    <script src="js/themeVariableIcons.js"></script>

</body>
</html>