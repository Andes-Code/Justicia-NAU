<?php
require_once "usuario.php";
require_once "afiliado.php";
require_once "localidad.php";
require_once "peticion.php";
require_once "destino.php";

class PeticionPlus extends Peticion{
    

    // private PeticionMultiple $nroPet_multiple;
    public function __construct(int $nroPet, int $estado, int $objFirmas, string $fecha=NULL, string $titulo=NULL, string $cuerpo=NULL, Destino $destino=NULL, Usuario|Afiliado $usuario=NULL, Localidad $localidad=NULL, array $tematicas=[]){
        parent::__construct($nroPet, $estado, $objFirmas, $fecha, $titulo, $cuerpo, $destino, $usuario, $localidad, $tematicas);
    }
}