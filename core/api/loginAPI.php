<?php
require_once "../../classes/webUser.php";
session_start();
if (isset($_SESSION["usuario"]) || isset($_SESSION["time"]))
{
    print_r(
        json_encode([
            "status"=>"failed",
            "cause"=>"sesion almost exist",
            "redirect"=>"index.php"
            ])
        );
    exit();
}
$correo = $_POST["correo"];
if (!filter_var($correo, FILTER_VALIDATE_EMAIL))
{
    session_destroy();
    print_r(json_encode([
        "status"=>"failed",
        "cause"=>"invalid email"    
        ])
    );
    exit();
    
}
$usuario = new WebUser();
if (!$usuario->iniciarSesion($correo))
{
    session_destroy();
    print_r(json_encode([
        "status"=>"failed",
        "cause"=>"invalid email2",
        ])
    );
    exit();
}

$_SESSION["usuario"]=$usuario;
$_SESSION["time"]=time();
print_r(json_encode([
    "status"=>"success",
    "cause"=>"None",
    "redirect"=>"../index.php"
    ])
);
exit();

?>