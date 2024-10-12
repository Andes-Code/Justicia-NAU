<?php
require_once "../../classes/webUser.php";
require_once "../../classes/BDconection.php";
session_start();
if (isset($_SESSION["usuario"]) || isset($_SESSION["time"])){
    echo "tienes que cerrar sesion para crear una nueva";
    exit();
}

if ()


?>