<?php
require_once "usuario.php";
require_once "localidad.php";
class Afiliado extends Usuario{
    private string $nombre;
    private bool $firma_anon;
    private string $fecha_n;
    private bool $TFA;
    private Localidad $localidad;

    public function __construct(string $correo, int $sancion, bool $verificado, string $nombre, bool $firma_anon, string $fecha_n, bool $tfa, Localidad $localidad){
        parent::__construct($correo,$sancion,$verificado);
        $this->nombre=$nombre;
        $this->firma_anon=$firma_anon;
        $this->fecha_n=$fecha_n;
        $this->TFA=$tfa;
        $this->localidad=$localidad;
    }   
    public function getLocalidad(){
        return $this->localidad;
    }
}

// $a= new Afiliado("santi@gmail.com",0,FALSE,"santiago",FALSE,"20020817",FALSE);
// echo $a->getMail();


?>