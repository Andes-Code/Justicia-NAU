<?php
require_once "usuario.php";
require_once "afiliado.php";
require_once "peticion.php";

class Firma{
    // private Peticion $peticion;
    private Usuario|Afiliado $usuario;
    private string $fecha;
    private bool $anonima;
    private string $comentario;

    public function __construct(Usuario|Afiliado $usuario, string $fecha, bool $anonima, string $comentario){
        // $this->peticion=$peticion;
        $this->usuario=$usuario;
        $this->fecha=$fecha;
        $this->anonima=$anonima;
        $this->comentario=$comentario;
    }
    public static function mostrarFirmaDesdeArray(array $firma){
        $div="
<div class='box'>
    <article class='media'>
        <div class='media-left'>
            <figure class='image is-64x64'>
                <img src='images/profiles/{$firma["imagen"]}' alt='Image' />
            </figure>
        </div>
        <div class='media-content'>
            <div class='content'>
                <p>
                <strong>{$firma["usuario"]}</strong> <small></small>
                <small>{$firma["fecha"]}</small>
                <br />
                {$firma["comentario"]}
                </p>
            </div>
            <!--nav class='level is-mobile'>
                <div class='level-left'>
                    <a class='level-item' aria-label='reply'>
                        <span class='icon is-small'>
                        <i class='fas fa-reply' aria-hidden='true'></i>
                        </span>
                    </a>
                    <a class='level-item' aria-label='retweet'>
                        <span class='icon is-small'>
                        <i class='fas fa-retweet' aria-hidden='true'></i>
                        </span>
                    </a>
                    <a class='level-item' aria-label='like'>
                        <span class='icon is-small'>
                        <i class='fas fa-heart' aria-hidden='true'></i>
                        </span>
                    </a>
                </div>
            </nav-->
        </div>
    </article>
</div>";
        return $div;
    }
    public static function mostrarComentarioPDF(array $datos) : string {
        $div="<p><strong> - {$datos['usuario']}:</strong> {$datos['comentario']}</p><span>".substr($datos['fecha'],8,2).'/'.substr($datos['fecha'],5,2).'/'.substr($datos['fecha'],0,4)."</span>";
        return $div;
    }
}
?>