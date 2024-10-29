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
    <title>Justicia NAU</title>
    <!-- <link rel="stylesheet" href="./css/indexStyle.css"> -->
    <!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.1/css/bulma.min.css">
    <link rel="stylesheet" href="./css/modifyIndexStyle.css">-->
    <link href="styles.css" rel="stylesheet">
    <link rel="manifest" href="./js/manifest.json">
    <script src="https://kit.fontawesome.com/e0fe908279.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <div>
    <header>
    <!-- KBD -->
        <section class="-mt-16 bg-center max-h-full bg-no-repeat bg-[url('images/hands.png')] bg-gray-700 bg-blend-multiply">
            <div class=" backdrop-blur-sm px-4 mx-auto max-w-screen-xl text-center py-24 lg:py-56">
                <h1 class="-pt-10 mb-8 text-4xl text-white font-black" >Justicia NAU</h1>
                <h2 class="mb-4 text-3xl font-extrabold tracking-tight leading-none text-white md:text-5xl lg:text-6xl">Por una sociedad mas justa</h2>
                <p class="my-[15px] text-lg font-normal text-white lg:text-xl sm:px-16 lg:px-48">El cambio comienza con una sola voz, pero el eco de miles puede transformar el mundo.</p>
                <div class="flex flex-col space-y-4 sm:flex-row sm:justify-center sm:space-y-0">
                    <a href="redact.php" class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white rounded-lg bg-red hover:bg-red focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900">
                        Haz una petición
                        <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                        </svg>
                    </a>
                    <a href="#peticiones" class="inline-flex justify-center hover:text-gray-900 items-center py-3 px-5 sm:ms-4 text-base font-medium text-center text-white rounded-lg border border-white hover:bg-gray focus:ring-4 focus:ring-gray">
                        Ver peticiones
                        <svg class="w-3.5 h-3.5 ms-2 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                        </svg>
                    </a>  
                </div>
            </div>
        </section>
    </header>

    <div class="m-2 mt-4" id='peticiones'>
        <?php $app->displayPetitions(0) ?>
    </div>
    <footer id="footer" class='fixed bottom-0 left-0 w-full backdrop-blur-sm'>
        <div class="flex justify-around items-center py-2 backdrop-blur-sm">
            <?php $app->renderFooter(get_included_files()[0]) ?>
        </div>
        
    </footer>
    <?php $app->renderTemplate("firma.php") ?>
    <?php $app->renderTemplate("firmas.php") ?>
    
    <script src="js/bulma.js"></script>
    <script src="js/index.js"></script>
    <script src="js/themeVariableIcons.js"></script>
</div>
</body>
</html>