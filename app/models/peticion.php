<?php
require_once "usuario.php";
require_once "afiliado.php";
require_once "localidad.php";
require_once "destino.php";
require_once "tematica.php";
require_once "peticionMultiple.php";

class Peticion{
    private int $nroPet;
    private int $estado;
    private int $objFirmas;
    private string $titulo;
    private string $cuerpo;
    private string $fecha;
    private Usuario|Afiliado $usuario;
    private array $tematicas;
    private array $firmas;
    private array $imagenes;
    private ?Destino $destino;
    private ?Localidad $localidad;
    private ?PeticionMultiple $pet_multiple;
    private array $meses = [
        "01" => "Ene",
        "02" => "Feb",
        "03" => "Mar",
        "04" => "Abr",
        "05" => "May",
        "06" => "Jun",
        "07" => "Jul",
        "08" => "Ago",
        "09" => "Sep",
        "10" => "Oct",
        "11" => "Nov",
        "12" => "Dic"
    ];
    private array $mesesPDF = [
        "01" => "Enero",
        "02" => "Febrero",
        "03" => "Marzo",
        "04" => "Abril",
        "05" => "Mayo",
        "06" => "Junio",
        "07" => "Julio",
        "08" => "Agosto",
        "09" => "Septiembre",
        "10" => "Octubre",
        "11" => "Noviembre",
        "12" => "Diciembre"
    ];
    
    public function __construct(int $nroPet, int $estado, int $objFirmas, string $fecha=NULL, string $titulo=NULL, string $cuerpo=NULL, Usuario|Afiliado $usuario=NULL, array $tematicas=[], array $firmas=[], array $imagenes=[], Destino $destino=NULL, Localidad $localidad=NULL,  PeticionMultiple $pet_multiple=NULL){
        $this->nroPet = $nroPet;
        $this->estado = $estado;
        $this->objFirmas = $objFirmas;
        $this->titulo = $titulo;
        $this->cuerpo = $cuerpo;
        // $this->fecha = substr($fecha,11,5)." - ".substr($fecha,8,2)." ".$this->meses[substr($fecha,5,2)]." ".substr($fecha,0,4);
        $this->fecha = $fecha;
        $this->usuario = $usuario;
        $this->tematicas = $tematicas;
        $this->firmas = $firmas;
        $this->imagenes = $imagenes;
        $this->destino=$destino;
        $this->localidad = $localidad;
        $this->pet_multiple = $pet_multiple;
    }
    public function getHTMLforPDF():string|bool{
        if ($this->estado==1){
            $html="";
            return $html;
        }
        return FALSE;
    }
    public function getFecha():string{
        return substr($this->fecha,11,5)." - ".substr($this->fecha,8,2)." ".$this->meses[substr($this->fecha,5,2)]." ".substr($this->fecha,0,4);
    }
    public function getObjetivo():int{
        return $this->objFirmas;
    }
    public function getFechaForPDF():string{
        return substr($this->fecha,8,2)." de ".$this->mesesPDF[substr($this->fecha,5,2)]." del ".substr($this->fecha,0,4).", ".substr($this->fecha,11,5)."hs";
    }
    public function esMostrable():bool {
        return $this->estado>=0;
        
    }
    public function evaluarObjetivo():bool{
        $objActual=$this->objFirmas;
        $cantFirmas=count($this->firmas);
        if ($objActual==$cantFirmas)
            return $objActual*1.75;
        return $objActual;
    }
    public function mostrarPeticion(bool $firmada, string $correoVeedor){
        $opciones=$this->opcionesPeticion($correoVeedor);
        $peticion= "
            <div class='inline-block bg-red-50 mb-2 p-3 rounded-lg' style='box-shadow: 0 3px 10px rgb(0,0,0,0.2);'>
            <div class='flex flex-row items-center p-1 rounded-lg shadow w-full'>
                <div class='flex space-x-4'>
                    <div class='image-div'>
                        <div>
                            <figure class='image'>
                                <a href='profile.php?user={$this->usuario->getCorreo()}'>
                                    <img class='min-w-10 w-10 h-10 rounded-full' src='images/profiles/{$this->usuario->mostrarImagen()}'>
                                </a>
                            </figure>
                        </div>
                    </div>
                    <div class='post-header'>
                        <div>
                            <h5 class='text-pretty text-l font-bold tracking-tight text-gray-900 dark:text-white truncate'>{$this->titulo}</h5>
                        </div>
                        <div>
                            <a href='profile.php?user={$this->usuario->getCorreo()}' class='search-link'>
                                <p class='font-normal text-gray-100 dark:text-gray-400'>{$this->usuario->getNombre()}</p>
                            </a>
                        </div>
                    </div>
                </div>

                <!--
                <div class='options-dropdown'>
                    <div class='dropdown is-right is-hoverable'>
                        <div class='dropdown-trigger'>
                            <button class='button' aria-haspopup='true' aria-controls='dropdown-menu3'>
                            <span>...</span>
                            <span class='icon is-small'>
                                <i class='fas fa-angle-down' aria-hidden='true'></i>
                            </span>
                            </button>
                        </div>
                        <div class='dropdown-menu' id='dropdown-menu3' role='menu'>";
                        $peticion.=$this->opcionesPeticion($correoVeedor);
                        $peticion.="
                        </div>
                    </div>
                </div> -->
                </div>
                <div class='card-content'>
                    <div class='mt-1.5 px-4'> 
                        <p >{$this->cuerpo}</p><br>";
                            foreach ($this->tematicas as $tematica){
                                $peticion.="<a !important class='text-blue-600' href='search.php?search={$tematica->getNombre()}'><p >#{$tematica->getNombre()}</p> </a>";
                            }
                                $peticion.="           
                    </div>
                    <div class='grid grid-cols-2 md:grid-cols-4 gap-4 {$this->cssClassForImages()}'>";
        $arregloModales=[];
        foreach ($this->imagenes as $imagen){
            $aux=$imagen->showImagen();
            // echo "
            //             <img src='images/{$imagen->showImagen()}'>";
            $peticion.= "
                        <div>
                            <button data-modal-target='{$aux}' data-modal-toggle='{$aux}'>
                                <img class='h-auto max-w-full rounded-lg' data-modal-target='{$aux}' data-modal-toggle='{$aux}' src='images/{$aux}'>
                            </button>
                        </div>";
            $arregloModales[].="
                        <div id='{$aux}' tabindex='-1' aria-hidden='true' class='hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full'>
                            <div class='relative p-4 w-full max-w-2xl max-h-full'>
                                <div class='relative bg-white rounded-lg shadow dark:bg-gray-700'>
                                    <p class='image'>
                                    <img src='images/{$aux}'>
                                    </p>
                                </div>
                            </div>
                            <button class='modal-close is-large' aria-label='close'></button>
                        </div>";
        }
        $peticion.=" 
                    </div>";
        $p=false;
        if ($this->destino!=NULL && $this->destino->esValido())
        {
            $peticion.= "
                    <p class='mt-4' >Destino: {$this->destino->getNombre()}</p>";
                    $p=true;
        }
        if ($this->localidad!=NULL)
        {
            if(!$p)
            {
                $p=true;
            }
            $peticion.= " <p>Localidad: {$this->localidad->getNombre()}</p>";

        }
        if($p)
        $arregloAlgFirmas=$this->algoritmoFirmas();
        $peticion.="
                <time class='-mt-4' datetime='{$this->fecha}'>{$this->getFecha()}</time>
                
                </div>
                <div class='mark1'>
                    {$arregloAlgFirmas['texto']}
                    <progress class='h-3 w-full' value='{$this->getCantFirmas()}' id='progress{$this->nroPet}' max='{$this->objFirmas}' style='--value: {$this->getCantFirmas()}; --max: {$this->objFirmas};'></progress>";
        if ($firmada)
        {
            $peticion.="
            </div>
                    <footer class='card-footer mt-4'>
                        <div class='grid grid-cols-2 rounded-md shadow-sm' role='group'>
                            <button value='{$this->nroPet}' id='firmar{$this->nroPet}' type='button' class='px-4 py-2 text-sm font-medium text-gray-900 rounded-s-lg hover:bg-gray-900  focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900  dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700' style='box-shadow: rgba(13, 38, 76, 0.19) 0px 9px 20px; background-color: #e94f37; color: #FFDAD4;'>
                                Quitar Firma
                            </button>
                            <button value='{$this->nroPet}' id='verFirmas{$this->nroPet}' type='button' class='px-4 py-2 text-sm font-medium text-gray-900 bg-transparent shadow-ragnarok rounded-e-lg hover:bg-gray-900 focus:shadow-warm focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700' style='box-shadow: rgba(13, 38, 76, 0.19) 0px 9px 20px; background-color: #FFC248; color: 3#A06C05;'>
                                Ver Firmas
                            </button>
                        </div>
                    </footer>
                    <!-- ANTERIORES BOTONES FUNCIONALES
                        <footer class='card-footer'>
                            <button value='{$this->nroPet}' id='firmar{$this->nroPet}' class='button card-footer-item sign is-danger'>Quitar Firma</button>
                            <button value='{$this->nroPet}' id='verFirmas{$this->nroPet}' class='button card-footer-item view-signers is-dark'>Ver firmas</button>
                        </footer>
                        -->
                </div>";
        }else
            $peticion.="
            </div>
                    <footer class='card-footer mt-4'>
                        <div class='grid grid-cols-2 rounded-md shadow-sm' role='group'>
                            <button data-modal-target='firma' data-modal-toggle='firma' value='{$this->nroPet}' id='firmar{$this->nroPet}' type='button' class='px-4 py-2 text-sm font-medium text-gray-900 bg-transparent box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px; rounded-s-lg hover:bg-gray-900  focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900  dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700' style='box-shadow: rgba(13, 38, 76, 0.19) 0px 9px 20px; background-color: #ccff00; color: #5F7603;'>
                                Firmar
                            </button>
                            <button value='{$this->nroPet}' id='verFirmas{$this->nroPet}' type='button' class='px-4 py-2 text-sm font-medium text-gray-900 bg-transparent box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px; rounded-e-lg hover:bg-gray-900  focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900  dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700' style='box-shadow: rgba(13, 38, 76, 0.19) 0px 9px 20px;  background-color: #FFC248; color: 3#A06C05;'>
                                Ver Firmas
                            </button>
                        </div>
                    </footer>
                    <!-- ANTERIORES BOTONES FUNCIONALES
                        <footer class='card-footer'>
                            <button value='{$this->nroPet}' id='firmar{$this->nroPet}' class='button card-footer-item sign is-dark'>Firmar</button>
                            <button value='{$this->nroPet}' id='verFirmas{$this->nroPet}' class='button card-footer-item view-signers is-dark'>Ver firmas</button>
                        </footer>
                        -->
                </div>";
        {

        }
        return $peticion;
    }
    public function getCantFirmas():int{
        return count($this->firmas);
    }
    public function cssClassForImages():string{
        $cont=count($this->imagenes);
        if ($cont==1){
            return "one";
        }
        else if ($cont==2){
            return "two";
        }
        else if ($cont==3){
            return "three";
        }
        else if ($cont==4){
            return "four";
        }
        else{
            return "display-off";
        }
    }
    public function getNumero():int{
        return $this->nroPet;
    }
    public function mostrarEnlace(){
        $enlace="
        <a href='search.php?petition={$this->nroPet}' class='search-link'>
            <div class='search-box'>
                <div class='inline-block bg-red-50 mb-2 p-3 rounded-lg' style='box-shadow: 0 3px 10px rgb(0,0,0,0.2);'>
                    <div class='flex flex-row items-center p-1 rounded-lg shadow w-full space-x-4 mb-3'>
                        <div class='flex'>
                            <div>
                                <figure class='image'>
                                <img class='min-w-10 w-10 h-10 rounded-full' src='images/profiles/{$this->usuario->mostrarImagen()}'>
                                </figure>
                            </div>
                        </div>
                        <div class='post-header'>
                            <p class='font-normal text-gray-100 dark:text-gray-400'> {$this->usuario->getNombre()}
                            </p>
                            <div class='font-normal text-gray-100 dark:text-gray-400'> {$this->usuario->getCorreo()}
                            </div>
                        </div>
                    </div>
                    <div class='middle'>
                        <div class='post-body'> {$this->cuerpo}           
                        </div>
                    </div>
                </div>
            </div>
        </a>        
                    ";
                    return $enlace;
    }
    public function algoritmoFirmas(){
        $objetivo = $this->objFirmas;
        $cantidad = $this->getCantFirmas();
        try{
            $porcActual=$cantidad/$objetivo*100;
        }catch (DivisionByZeroError $e){
            $porcActual=0;
        }
        $porcActual=number_format($porcActual,2,".");
        $texto="<p class='font-black text-lg mt-4 text-center'>$cantidad / $objetivo</p>";
        return [
            "texto"=>$texto,
            "porcentaje"=>$porcActual
        ];
        // if ($cantidad==0) 
        //     $porcActual = 0;
        // else{
        //     // echo "$cantidad / $objetivo * 100;";
        //     $porcActual = $cantidad/$objetivo*100;
            
        // }
        // if ($objetivo>300 && $porcActual < 80 && $porcActual>0){ 
        //     if ($porcActual >= 75) {
        //         $objetivo = intval($objetivo * 0.8);
        //     }
        //     else if ($porcActual >= 60) {
        //         $objetivo = intval($objetivo * 0.75);
        //     }
        //     else if ($porcActual >= 65) {
        //         $objetivo = intval($objetivo * 0.70);
        //     }
        //     else if ($porcActual >= 60) {
        //         $objetivo = intval($objetivo * 0.65);
        //     }
        //     else if ($porcActual >= 55) {
        //         $objetivo = intval($objetivo * 0.60);
        //     }
        //     else if ($porcActual >= 50) {
        //         $objetivo = intval($objetivo * 0.55);
        //     }
        //     else if ($porcActual >= 45) {
        //         $objetivo = intval($objetivo * 0.5);
        //     }
        //     else if ($porcActual >= 40) {
        //         $objetivo = intval($objetivo * 0.45);
        //     }
        //     else if ($porcActual >= 35) {
        //         $objetivo = intval($objetivo * 0.4);
        //     }
        //     else if ($porcActual >= 30) {
        //         $objetivo = intval($objetivo * 0.35);
        //     }
        //     else if ($porcActual >= 25) {
        //         $objetivo = intval($objetivo * 0.3);
        //     }
        //     else if ($porcActual >= 20) {
        //         $objetivo = intval($objetivo * 0.25);
        //     }
        //     else if ($porcActual >= 15) {
        //         $objetivo = intval($objetivo * 0.20);
        //     }
        //     else if ($porcActual >= 10) {
        //         $objetivo = intval($objetivo * 0.15);
        //     }
        //     else if ($porcActual >= 8) {
        //         $objetivo = intval($objetivo * 0.1);
        //     }
        //     else if ($porcActual >= 6) {
        //         $objetivo = intval($objetivo * 0.08);
        //     }
        //     else if ($porcActual >= 4) {
        //         $objetivo = intval($objetivo * 0.06);
        //     }
        //     else if ($porcActual >= 2) {
        //         $objetivo = intval($objetivo * 0.04);
        //         // goto a;
        //     }
        //     else if ($objetivo >=100000) {
        //         $objetivo = intval($objetivo * 0.01);
        //         // echo "$cantidad / $objetivo * 100;";
        //     }
        //     else if ($objetivo >1000) {
        //         $objetivo = intval($objetivo * 0.02);
        //         // echo "$cantidad / $objetivo * 100;";
        //     }
        //     // echo "$cantidad a a obj $objetivo";
        //     try{
        //         $porcActual = $cantidad/$objetivo*100;
        //     }catch (DivisionByZeroError $e){
        //         a:
        //         return "<p>ocurrio un error, por favor <a href='reportar.php?peticion={$this->nroPet}&en=algoritmo_firmas>reporte este error</a>.</p>";
        //         // return "obj = $objetivo <br> cantidad = $cantidad<br> pet = {$this->nroPet}";
        //     }
        // }
        
        // $porcActual = number_format($porcActual,2,".");
        // $texto="<span id='percSpan{$this->nroPet}'>$porcActual%: </span><span id='cantSpan{$this->nroPet}'>$cantidad</span><span>/</span><span id='objSpan{$this->nroPet}'>$objetivo</span>";
        // return [
        //     "texto"=>$texto,
        //     "porcentaje"=>$porcActual
        // ];
        
    }
    public function mostrarPeticionNueva(){
        $peticion="
        <div class='card'>
            <header class='card-header'>
                <p class='card-header-title'>  {$this->titulo}  </p>
                <button class='card-header-icon' aria-label='more options'>
                    <span class='icon'>
                        <i class='fas fa-angle-down' aria-hidden='true'></i>
                    </span>
                </button>
            </header>
            <div class='card-content'>
                <div class='content'>
                {$this->cuerpo}
                <br />";
            foreach ($this->tematicas as $tematica){
                $peticion.="
                <a href='#'>  #{$tematica->getNombre()}</a>";
    
            }
            $peticion.="
            <br />
            <div class='post-images {$this->cssClassForImages()}'>";
        $arregloModales=[];
        foreach ($this->imagenes as $imagen){
            $aux=$imagen->showImagen();
            // echo "
            //             <img src='images/{$imagen->showImagen()}'>";
            $peticion.= "
                        <div class='post-imagen'>
                            <img class='js-modal-trigger' data-target='{$aux}' src='images/{$aux}'>
                        </div>";
            $arregloModales[].="
                        <div id='{$aux}' class='modal'>
                            <div class='modal-background'></div>
                            <div class='modal-content'>
                                <p class='image'>
                                <img src='images/{$aux}'>
                                </p>
                            </div>
                            <button class='modal-close is-large' aria-label='close'></button>
                        </div>";
        }
        $peticion.=" 
                    </div>
                    <div>";
        foreach ($arregloModales as $modal){
            $peticion.=$modal;
        }
        $destino=$this->destino ? "<a>".$this->destino->getNombre()."</a>" : "no especificado";
        $localidad=$this->localidad ? "<a>".$this->localidad->getNombre()."</a>" : "no especificado";
        $peticion.="
                </div>
                    <p>
                        <span>Destino: {$destino}</span><br>
                        <span>Localidad: {$localidad}</span><br>
                        <span>Usuario: <a href='profile.php?user={$this->usuario->getCorreo()}'>{$this->usuario->getCorreo()}</a></span>
                    </p>
                    <time datetime='{$this->fecha}'>{$this->getFecha()}</time>
            </div>
            </div>
            <footer class='card-footer'>
                <a data-target='{$this->nroPet}' class='card-footer-item admitir'>Admitir</a>
                <!--a data-target='{$this->nroPet}' class='card-footer-item'>Editar</a-->
                <a data-target='{$this->nroPet}' class='card-footer-item is-danger bajar'>Eliminar</a>
            </footer>
        </div>";
        echo $peticion;
    }
    public function mostrarPeticionFinalizadaAdmin(){
        $peticion="
        <div class='card'>
            <header class='card-header'>
                <p class='card-header-title'>  {$this->titulo}  </p>
                <button class='card-header-icon' aria-label='more options'>
                    <span class='icon'>
                        <i class='fas fa-angle-down' aria-hidden='true'></i>
                    </span>
                </button>
            </header>
            <div class='card-content'>
                <div class='content'>
                {$this->cuerpo}
                <br />";
            foreach ($this->tematicas as $tematica){
                $peticion.="
                <a href='#'>  #{$tematica->getNombre()}</a>";
    
            }
            $peticion.="
            <br />
            <div class='post-images {$this->cssClassForImages()}'>";
        $arregloModales=[];
        foreach ($this->imagenes as $imagen){
            $aux=$imagen->showImagen();
            // echo "
            //             <img src='images/{$imagen->showImagen()}'>";
            $peticion.= "
                        <div class='post-imagen'>
                            <img class='js-modal-trigger' data-target='{$aux}' src='images/{$aux}'>
                        </div>";
            $arregloModales[].="
                        <div id='{$aux}' class='modal'>
                            <div class='modal-background'></div>
                            <div class='modal-content'>
                                <p class='image'>
                                <img src='images/{$aux}'>
                                </p>
                            </div>
                            <button class='modal-close is-large' aria-label='close'></button>
                        </div>";
        }
        $peticion.=" 
                    </div>
                    <div>";
        foreach ($arregloModales as $modal){
            $peticion.=$modal;
        }
        $destino=$this->destino ? "<a>".$this->destino->getNombre()."</a>" : "no especificado";
        $localidad=$this->localidad ? "<a>".$this->localidad->getNombre()."</a>" : "no especificado";
        $peticion.="
                </div>
                    <p>
                        <span>Destino: {$destino}</span><br>
                        <span>Localidad: {$localidad}</span><br>
                        <span>Usuario: <a href='profile.php?user={$this->usuario->getCorreo()}'>{$this->usuario->getCorreo()}</a></span><br>
                        <span>Objetivo de firmas: {$this->objFirmas}</span><br>
                        <span>Firmas obtenidas: ".count($this->firmas)."</span>
                    </p>
                    <time datetime='{$this->fecha}'>{$this->getFecha()}</time>
            </div>
            </div>
            <footer class='card-footer'>
                <!--a data-target='{$this->nroPet}' class='card-footer-item admitir'>Admitir</a-->
                <!--a data-target='{$this->nroPet}' class='card-footer-item'>Editar</a-->
                <a data-target='{$this->nroPet}' class='card-footer-item is-danger generarPDF'>Generar PDF</a>
            </footer>
        </div>";
        echo $peticion;
    }
    public function estaTerminada() : bool {
        return $this->estado==1;
        
    }
    public function mostrarPeticionFinalizadaVisitante(){
        $peticion="
        <div class='card'>
            <header class='card-header'>
                <p class='card-header-title'>Peticion N° {$this->nroPet}:  {$this->titulo}  </p>
                <button class='card-header-icon' aria-label='more options'>
                    <span class='icon'>
                        <i class='fas fa-angle-down' aria-hidden='true'></i>
                    </span>
                </button>
            </header>
            <div class='card-content'>
                <div class='content'>
                {$this->cuerpo}
                <br />";
            foreach ($this->tematicas as $tematica){
                $peticion.="
                <a href='#'>  #{$tematica->getNombre()}</a>";
    
            }
            $peticion.="
            <br />
            <div class='post-images {$this->cssClassForImages()}'>";
        $arregloModales=[];
        foreach ($this->imagenes as $imagen){
            $aux=$imagen->showImagen();
            $peticion.= "
                        <div class='post-imagen'>
                            <img class='js-modal-trigger' data-target='{$aux}' src='images/{$aux}'>
                        </div>";
            $arregloModales[].="
                        <div id='{$aux}' class='modal'>
                            <div class='modal-background'></div>
                            <div class='modal-content'>
                                <p class='image'>
                                <img src='images/{$aux}'>
                                </p>
                            </div>
                            <button class='modal-close is-large' aria-label='close'></button>
                        </div>";
        }
        $peticion.=" 
                    </div>
                    <div>";
        foreach ($arregloModales as $modal){
            $peticion.=$modal;
        }
        $destino=$this->destino ? "<a>".$this->destino->getNombre()."</a>" : "no especificado";
        $localidad=$this->localidad ? "<a>".$this->localidad->getNombre()."</a>" : "no especificado";
        $peticion.="
                </div>
                    <p>
                        <span> - Destino: {$destino}</span><br>
                        <span> - Localidad: {$localidad}</span><br>
                        <span> - Usuario: <a href='profile.php?user={$this->usuario->getCorreo()}'>{$this->usuario->getCorreo()}</a></span><br>
                        <span> - Objetivo de firmas: {$this->objFirmas}</span><br>
                        <span> - Firmas obtenidas: ".count($this->firmas)."</span>
                    </p>
                    <time datetime='{$this->fecha}'>{$this->getFecha()}</time>
            </div>
            </div>
            <footer class='card-footer'>
                <a href='index.php' class='card-footer-item'>Visitar la App</a>
            </footer>
        </div>";
        echo $peticion;
    }
    public function getDatosEnArreglo() : array {
        $arreglo=[];
        if ($this->estado==1)
        {
            $arreglo["titulo"]=$this->titulo;
            $arreglo["cuerpo"]=$this->cuerpo;
            $arreglo["objFirmas"]=$this->objFirmas;
            $arreglo["fechaCreacion"]=$this->getFechaForPDF();
            $arreglo["firmas"]=count($this->firmas);
            $arreglo["imagenes"]=$this->imagenes;
            $arreglo["nombre"]=$this->usuario->getNombre();
            $arreglo["correo"]=$this->usuario->getCorreo();
            $arreglo["localidad"]= ($this->localidad instanceof Localidad) ? $this->localidad->getNombre() : "";
            $arreglo["destino"]= ($this->destino instanceof Destino) ? "Dirigido a: ".$this->destino->getNombre() : "";
        }
        return $arreglo;
        
    }
    private function esDe(string $correo):bool{
        return $this->usuario->getCorreo()==$correo;
    }
    private function opcionesPeticion(string $correoVeedor){
        $div="";
        // opciones para todo usuario
        $div.="
        <div class='dropdown-content'>
            <a href='search.php?petition={$this->nroPet}' class='dropdown-item'> Ver </a>";
        if ($correoVeedor!='')
        {
            // require_once "../controllers/controladorUsuarios.php";
            if ($this->usuario->getCorreo()==$correoVeedor)
            {
               $div.="
               <a href='search.php?petition={$this->nroPet}' class='dropdown-item'> finalizar peticion </a>
               ";
            }
            $usuario=Usuarios::getUsuarioByCorreo($correoVeedor);
            if ($usuario->isAdmin())
            {
                $div.="
                    <hr class='dropdown-divider' />
                    <a href='search.php?petition={$this->nroPet}' class='dropdown-item'> BAJAR </a>
                    <a href='#' class='dropdown-item'> Generar PDF </a>";
            }
            if ($usuario->isModerador())
            {
                $div.="
                    <hr class='dropdown-divider' />
                    <a href='search.php?petition={$this->nroPet}' class='dropdown-item'> opcion moder </a>
                    <a href='#' class='dropdown-item'> opcion moder </a>";
            }
            $div.="
                <hr class='dropdown-divider' />
                <a href='#' class='dropdown-item'> Denunciar </a>";
        }
        $div.="
            <a href='#' class='dropdown-item'> Compartir </a>
        </div>";
        return $div;
    }
}

?>