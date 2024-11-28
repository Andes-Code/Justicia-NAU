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
        // previo
        // $div="
        // <div class='box'>
        //     <article class='media'>
        //         <div class='media-left'>
        //             <figure class='image is-64x64'>
        //                 <img src='images/profiles/{$firma["imagen"]}' alt='Image' />
        //             </figure>
        //         </div>
        //         <div class='media-content'>
        //             <div class='content'>
        //                 <p>
        //                 <strong>{$firma["usuario"]}</strong> <small></small>
        //                 <small>{$firma["fecha"]}</small>
        //                 <br />
        //                 {$firma["comentario"]}
        //                 </p>
        //             </div>
        //             <!--nav class='level is-mobile'>
        //                 <div class='level-left'>
        //                     <a class='level-item' aria-label='reply'>
        //                         <span class='icon is-small'>
        //                         <i class='fas fa-reply' aria-hidden='true'></i>
        //                         </span>
        //                     </a>
        //                     <a class='level-item' aria-label='retweet'>
        //                         <span class='icon is-small'>
        //                         <i class='fas fa-retweet' aria-hidden='true'></i>
        //                         </span>
        //                     </a>
        //                     <a class='level-item' aria-label='like'>
        //                         <span class='icon is-small'>
        //                         <i class='fas fa-heart' aria-hidden='true'></i>
        //                         </span>
        //                     </a>
        //                 </div>
        //             </nav-->
        //         </div>
        //     </article>
        // </div>";
        $div="
            <div class='flex w-full flex-row items-start justify-start gap-3 p-4'>
                <div class='bg-center bg-no-repeat aspect-square bg-cover rounded-full w-10 shrink-0' style='background-image: url(images/profiles/{$firma["imagen"]});'><img src='images/profiles/{$firma["imagen"]}' alt='Image' /></div>
                <div class='flex h-full flex-1 flex-col items-start justify-start'>
                    <div class='flex w-full flex-row items-start justify-start gap-x-3'>
                        <p class='text-[#111418] text-sm font-bold leading-normal tracking-[0.015em]'>{$firma["usuario"]}</p>
                        <p class='text-[#637588] text-sm font-normal leading-normal'>{$firma["fecha"]}</p>
                    </div>
                    <p class='text-[#111418] text-sm font-normal leading-normal'>{$firma["comentario"]}</p>
                    <div class='flex w-full flex-row items-center justify-start gap-9 pt-2'>
                        <div class='flex items-center gap-2'>
                        <!--div class='text-[#637588]' data-icon='ThumbsUp' data-size='20px' data-weight='regular'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='20px' height='20px' fill='currentColor' viewBox='0 0 256 256'>
                            <path
                                d='M234,80.12A24,24,0,0,0,216,72H160V56a40,40,0,0,0-40-40,8,8,0,0,0-7.16,4.42L75.06,96H32a16,16,0,0,0-16,16v88a16,16,0,0,0,16,16H204a24,24,0,0,0,23.82-21l12-96A24,24,0,0,0,234,80.12ZM32,112H72v88H32ZM223.94,97l-12,96a8,8,0,0,1-7.94,7H88V105.89l36.71-73.43A24,24,0,0,1,144,56V80a8,8,0,0,0,8,8h64a8,8,0,0,1,7.94,9Z'
                            ></path>
                            </svg>
                        </div-->
                        <p class='text-[#637588] text-sm font-normal leading-normal'></p>
                        </div>
                    </div>
                </div>
            </div>";
        return $div;
    }
    public static function mostrarComentarioPDF(array $datos) : string {
        $div="<p><strong> - {$datos['usuario']}:</strong> {$datos['comentario']}</p><span>".substr($datos['fecha'],8,2).'/'.substr($datos['fecha'],5,2).'/'.substr($datos['fecha'],0,4)."</span>";
        return $div;
    }
}
?>