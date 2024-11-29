<nav class="tabs">
  <ul class="flex flex-row justify-between">
    <li class="<?php if (isset($_GET["localidades"]) && ($_GET["localidades"]=="existentes")) echo "is-active" ?> border rounded-full p-2">
        <a href="options.php?mode=admin&page=localidades&localidades=existentes">Existentes</a>
    </li>
    <li class="<?php if (isset($_GET["localidades"]) && ($_GET["localidades"]=="nuevas")) echo "is-active" ?> border rounded-full p-2">
        <a href="options.php?mode=admin&page=localidades&localidades=nuevas">Nuevas</a>
    </li>
    <li class="<?php if (isset($_GET["localidades"]) && ($_GET["localidades"]=="agregar")) echo "is-active" ?> border rounded-full p-2">
        <a href="options.php?mode=admin&page=localidades&localidades=agregar">Agregar</a>
    </li>
    <li class="<?php if (isset($_GET["localidades"]) && ($_GET["localidades"]=="instrucciones")) echo "is-active" ?> border rounded-full p-2">
        <a href="options.php?mode=admin&page=localidades&localidades=instrucciones">Instrucciones</a>
    </li>
   
  </ul>
</nav>