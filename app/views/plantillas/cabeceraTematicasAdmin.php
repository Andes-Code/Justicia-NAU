<nav class="tabs">
  <ul class="flex flex-row justify-between">
    <li class="<?php if (isset($_GET["tematicas"]) && ($_GET["tematicas"]=="existentes")) echo "is-active" ?> border rounded-full p-2">
        <a href="options.php?mode=admin&page=tematicas&tematicas=existentes">Existentes</a>
    </li>
    <li class="<?php if (isset($_GET["tematicas"]) && ($_GET["tematicas"]=="nuevas")) echo "is-active" ?> border rounded-full p-2">
        <a href="options.php?mode=admin&page=tematicas&tematicas=nuevas">Nuevas</a>
    </li>
    <li class="<?php if (isset($_GET["tematicas"]) && ($_GET["tematicas"]=="agregar")) echo "is-active" ?> border rounded-full p-2">
        <a href="options.php?mode=admin&page=tematicas&tematicas=agregar">Agregar</a>
    </li>
    <li class="<?php if (isset($_GET["tematicas"]) && ($_GET["tematicas"]=="instrucciones")) echo "is-active" ?> border rounded-full p-2">
        <a href="options.php?mode=admin&page=tematicas&tematicas=instrucciones">Instrucciones</a>
    </li>
   
  </ul>
</nav>