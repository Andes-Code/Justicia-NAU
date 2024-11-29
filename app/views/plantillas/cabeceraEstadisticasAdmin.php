<?php $opcion= (isset($_GET["opcion"])) ? filter_var($_GET["opcion"],FILTER_SANITIZE_FULL_SPECIAL_CHARS) : ""; ?>
<nav id="nav-informe" class="tabs">
    <ul class="flex flex-row justify-between">
        <li class="<?php if ($opcion=="mensual") echo "is-active" ?> border rounded-full p-2">
            <a href="options.php?mode=admin&page=estadisticas&opcion=mensual">Mensual</a>
        </li>
        <li class="<?php if ($opcion=="anual") echo "is-active" ?> border rounded-full p-2">
            <a href="options.php?mode=admin&page=estadisticas&opcion=anual">Anual</a>
        </li>
        <li class="<?php if ($opcion=="comparar") echo "is-active" ?> border rounded-full p-2">
            <a href="options.php?mode=admin&page=estadisticas&opcion=comparar">Comparar</a>
        </li>
        <li class="<?php if ($opcion=="instrucciones") echo "is-active" ?> border rounded-full p-2">
            <a href="options.php?mode=admin&page=estadisticas&opcion=instrucciones">Instrucciones</a>
        </li>
    
    </ul>
</nav>
    
    

    <?php if ($opcion=="mensual")
    {?>
        <header id="header">
            <form class="mt-4">
                <div class="control pl-8 pr-8">
                    <label class="text-lgray text-pretty font-light text-center" for="fecha"><p class="text-center">Seleccione el mes del que desea obtener el informe</p></label>
                </div>
                <div class="field has-addons flex flex-row items-center justify-around my-4">
                    <div class="control">
                        <input type="month" class="input rounded-full w-[150px] h-[42px]" name="fecha" id="fechaInput">
                    </div>
                    <div class="control">
                        <button class="button is-dark border-2 rounded-full w-[150px] h-[42px]" type="button" id="searchInforme">
                        Generar Informe
                        </button>
                    </div>
                </div>
            </form>
        </header>
    <?php 
    } 
    else if ($opcion=="anual")
    {?>
        <header id="header">
            <form class="mt-4">
                <div class="control pl-8 pr-8">
                    <label class="text-lgray text-pretty font-light text-center" for="fecha"><p class="text-center">Seleccione el año del que desea obtener el informe</p></label>
                </div>
                <div class="field has-addons flex flex-row items-center justify-around my-4">
                    <div class="control">
                        <input placeholder="Ingrese año" type="number" class="input rounded-full w-[150px] h-[42px]" name="fecha" id="fechaInput" min="2024" max="<?php echo date("Y")?>">
                    </div>
                    <div class="control">
                        <button class="button is-dark border-2 rounded-full w-[150px] h-[42px]" type="button" id="searchInforme">
                        Generar Informe
                        </button>
                    </div>
                </div>
            </form>
        </header>
    <?php 
    }
    else if ($opcion=="comparar")
    {?>
        <header id="header">
            <form class="informe mt-4">
                <div class="control pl-8 pr-8">
                    <label class="text-lgray text-pretty font-light text-center" for="fecha"><p class="text-center">Seleccione los meses que desea comparar</p></label>
                </div>
                <div class="field has-addons flex flex-row items-center justify-around my-4" id="comparar">
                    <div class="control">
                        <input type="month" class="input rounded-full w-[150px] h-[42px]" name="fecha1" id="fechaInput1">
                    </div>
                    <div class="control">
                        <input type="month" class="input rounded-full w-[150px] h-[42px]" name="fecha2" id="fechaInput2">
                    </div>
                </div>
                <div class="control comparar-button-div flex justify-center">
                    <button class="button is-dark border-2 rounded-full w-[150px] h-[42px]" type="button" id="searchInforme">
                    Comparar
                    </button>
                </div>
            </form>
        </header>
    <?php }?>
    <div class="contentMy2">
    </div>