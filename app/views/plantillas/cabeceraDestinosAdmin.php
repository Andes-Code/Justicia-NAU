<nav class="tabs" aria-label="">
  <ul>
    <li class="<?php if (isset($_GET["destinos"]) && ($_GET["destinos"]=="existentes")) echo "is-active" ?>">
        <a href="options.php?mode=admin&page=destinos&destinos=existentes">Existentes</a>
    </li>
    <li class="<?php if (isset($_GET["destinos"]) && ($_GET["destinos"]=="nuevos")) echo "is-active" ?>">
        <a href="options.php?mode=admin&page=destinos&destinos=nuevos">Nuevos</a>
    </li>
    <li class="<?php if (isset($_GET["destinos"]) && ($_GET["destinos"]=="agregar")) echo "is-active" ?>">
        <a href="options.php?mode=admin&page=destinos&destinos=agregar">Agregar</a>
    </li>
    <li class="<?php if (isset($_GET["destinos"]) && ($_GET["destinos"]=="instrucciones")) echo "is-active" ?>">
        <a href="options.php?mode=admin&page=destinos&destinos=instrucciones">Instrucciones</a>
    </li>
   
  </ul>
</nav>
