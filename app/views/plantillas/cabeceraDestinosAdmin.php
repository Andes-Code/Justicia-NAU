<nav class="tabs" aria-label="">
  <ul class="flex flex-row justify-between">
    <li class="<?php if (isset($_GET["destinos"]) && ($_GET["destinos"]=="existentes")) echo "is-active" ?> border rounded-full p-2">
        <a href="options.php?mode=admin&page=destinos&destinos=existentes">Existentes</a>
    </li>
    <li class="<?php if (isset($_GET["destinos"]) && ($_GET["destinos"]=="nuevos")) echo "is-active" ?> border rounded-full p-2">
        <a href="options.php?mode=admin&page=destinos&destinos=nuevos">Nuevos</a>
    </li>
    <li class="<?php if (isset($_GET["destinos"]) && ($_GET["destinos"]=="agregar")) echo "is-active" ?> border rounded-full p-2">
        <a href="options.php?mode=admin&page=destinos&destinos=agregar">Agregar</a>
    </li>
    <li class="<?php if (isset($_GET["destinos"]) && ($_GET["destinos"]=="instrucciones")) echo "is-active" ?> border rounded-full p-2">
        <a href="options.php?mode=admin&page=destinos&destinos=instrucciones">Instrucciones</a>
    </li>
   
  </ul>
</nav>
