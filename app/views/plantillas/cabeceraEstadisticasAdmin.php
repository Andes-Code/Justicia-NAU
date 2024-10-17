<?php $opcion= (isset($_GET["opcion"])) ? filter_var($_GET["opcion"],FILTER_SANITIZE_FULL_SPECIAL_CHARS) : ""; ?>
<nav id="nav-informe" class="tabs">
    <ul>
        <li class="<?php if ($opcion=="mensual") echo "is-active" ?>">
            <a href="options.php?mode=admin&page=estadisticas&opcion=mensual">Mensual</a>
        </li>
        <li class="<?php if ($opcion=="anual") echo "is-active" ?>">
            <a href="options.php?mode=admin&page=estadisticas&opcion=anual">Anual</a>
        </li>
        <li class="<?php if ($opcion=="comparar") echo "is-active" ?>">
            <a href="options.php?mode=admin&page=estadisticas&opcion=comparar">Comparar</a>
        </li>
        <li class="<?php if ($opcion=="instrucciones") echo "is-active" ?>">
            <a href="options.php?mode=admin&page=estadisticas&opcion=instrucciones">Instrucciones</a>
        </li>
    
    </ul>
</nav>
    
    

    <?php if ($opcion=="mensual")
    {?>
        <header id="header">
            <form>
                <div class="control">
                    <label for="fecha">Seleccione el mes del que desea obtener el informe</label>
                </div>
                <div class="field has-addons">
                    <div class="control">
                        <input type="month" class="input" name="fecha" id="fechaInput">
                    </div>
                    <div class="control">
                        <button class="button is-dark" type="button" id="searchInforme">
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
            <form>
                <div class="control">
                    <label for="fecha">Seleccione el año del que desea obtener el informe</label>
                </div>
                <div class="field has-addons">
                    <div class="control">
                        <input placeholder="Ingrese año" type="number" class="input" name="fecha" id="fechaInput" min="2024" max="<?php echo date("Y")?>">
                    </div>
                    <div class="control">
                        <button class="button is-dark" type="button" id="searchInforme">
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
            <form class="informe">
                <div class="control">
                    <label for="fecha">Seleccione los meses que desea comparar</label>
                </div>
                <div class="field has-addons" id="comparar">
                    <div class="control">
                        <input type="month" class="input" name="fecha1" id="fechaInput1">
                    </div>
                    <div class="control">
                        <input type="month" class="input" name="fecha2" id="fechaInput2">
                    </div>
                </div>
                <div class="control comparar-button-div">
                    <button class="button is-dark comparar-button" type="button" id="searchInforme">
                    Comparar
                    </button>
                </div>
            </form>
        </header>
    <?php }?>
    <div class="contentMy2">
    </div>