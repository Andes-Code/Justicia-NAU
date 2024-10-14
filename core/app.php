<?php


class App{
    public function displayPetitions(int $cant,bool $ajax=FALSE){
        require_once "../app/controllers/controladorPeticiones.php";
        if ($ajax)
        {
            if ($this->validarSesion())
            {
                $peticiones=Peticiones::mostrarPeticiones($_SESSION["usuario"]->getUsuario()->getCorreo(),"correo",$cant);
                if ($peticiones && count($peticiones)>0){
                    print_r(json_encode([
                        "status"=>"success",
                        "peticiones"=>$peticiones
                    ]));
                }
                else
                {
                    print_r(json_encode([
                        "status"=>"wait",
                        "message"=>"No hay mas peticiones por mostrar"
                    ]));
                }
            }
            return;
        }
        else
        {
            if ($this->validarSesion())
            {
                $peticiones=Peticiones::mostrarPeticiones($_SESSION["usuario"]->getUsuario()->getCorreo(),"correo",$cant);

            }
            else
            {
                $usuario = new WebUser();
                $peticiones=Peticiones::mostrarPeticiones($usuario->getIP(),"ip",$cant);
            }
            if ($peticiones && count($peticiones)>0){
                foreach ($peticiones as $peticion)
                {
                    echo $peticion;
                }
            }
            echo Peticiones::loadMorePetitionsButton();
        }

    }
    public function getFileName($path){
        $arrayRuta=explode('\\',$path);
        $archivo=end($arrayRuta);
        $arrayArchivo=explode(".",$archivo);
        $archivo=$arrayArchivo[0];
        return $archivo;
    }
    public function renderFooter(string $file){
        $tema=(isset($_COOKIE["theme"]) && $_COOKIE["theme"]=="light") ? "light" : "dark";
        // print_r($_COOKIE);
        // exit();
        $archivo=$this->getFileName($file);
        echo $this->getFooterButton("index","$archivo",$tema);
        echo $this->getFooterButton("search","$archivo",$tema);
        echo $this->getFooterButton("redact","$archivo",$tema);
        echo $this->getFooterButton("profile","$archivo",$tema);
        echo $this->getFooterButton("options","$archivo",$tema);
    }
    public function getFooterButton(string $icono, string $pagina, string $tema="dark"):string{
        if ($icono==$pagina)
        {
            return "
            <div class='footer-button active'>
                <a>
                    <!--img src='images/icons/$tema/{$icono}.in.svg'-->
                    <img data-target='$icono.in' class='footer-img'>
                </a>
            </div>";
        }else
        {
            return "
            <div class='footer-button'>
                <a href='{$icono}.php'>
                    <!--img src='images/icons/$tema/{$icono}.svg'-->
                    <img data-target='$icono' class='footer-img'>
                </a>
            </div>";
        }
        // if ($icono==$pagina)
        // {
        //     return "
        //     <div class='footer-button active'>
        //         <a>
        //             <img src='images/icons/$tema/{$icono}.in.svg'>
        //         </a>
        //     </div>";
        // }else
        // {
        //     return "
        //     <div class='footer-button'>
        //         <a href='{$icono}.php'>
        //             <img src='images/icons/$tema/{$icono}.svg'>
        //         </a>
        //     </div>";
        // }
    }
    public function getIcono(string $icono,string $tema="dark"):string{
        return "
        <div class='icon-div'>
            <img class='icon footer-img' data-target='$icono'>
        </div>";
        
    }
    public function validarSesion(){
        if (!isset($_SESSION)) return FALSE;
        if (!isset($_SESSION["usuario"]) || !isset($_SESSION["time"])) return FALSE;
        if ($_SESSION["usuario"]->getUsuario()==FALSE) return FALSE;        
        // si se crean nuevas condiciones que indiquen si hay o no sesion iniciada, se agregan arriba
        return TRUE;
    }
    public function renderProfile(string $correo){
        if($usuario = Usuarios::getUsuarioByCorreo($correo))
            if ($this->validarSesion())
                echo $usuario->mostrarPerfil($_SESSION["usuario"]->getUsuario()->getCorreo(),"correo");
            else
            {
                $visitante = new WebUser();
                echo $usuario->mostrarPerfil($visitante->getIP(),"ip");

            }
        else
            echo "Perfil no encontrado";
            # $this->renderNoProfile();
    }
    public function renderNoProfile(){
        $_SESSION["redirect"]= 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        echo '
        <div class="notification is-link is-light">
            <!--button class="delete"></button-->
            <p>Vaya! vemos que no has iniciado sesion aun. </p>
            <p><strong>Si tienes una cuenta</strong> <a href="login.php">haz click aqui para iniciar sesion.</a></p>
            <p><strong>Sino </strong><a href="register.php">haz click aqui para registrarte.</a></p>
        </div>';
    }
    public function login(string $correo, string $psw){
        if (isset($_SESSION["usuario"]) && isset($_SESSION["time"]))
        {
            print_r(
                json_encode([
                    "status"=>"failed",
                    "message"=>"sesion almost exist",
                    "redirect"=>"index.php"
                    ])
                );
            exit();
        }
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL))
        {
            session_destroy();
            print_r(json_encode([
                "status"=>"failed",
                "message"=>"invalid email",    
                "inputError"=>"correo"

                ])
            );
            exit();
        }
        $usuario = new WebUser();
        $psw=filter_var($psw,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$usuario->iniciarSesion($correo,$psw))
        {
            session_destroy();
            print_r(json_encode([
                "status"=>"failed",
                "message"=>"invalid credentials",
                ])
            );
            exit();
        }

        $_SESSION["usuario"]=$usuario;
        $_SESSION["time"]=time();
        $redirect="index.php";
        if (isset($_SESSION["redirect"]) && $_SESSION["redirect"]!=""){
            $redirect=$_SESSION["redirect"];
            unset($_SESSION["redirect"]);
        }
        if (isset($_SESSION["forzarFirma"]))
            unset($_SESSION["forzarFirma"]);
        print_r(json_encode([
            "status"=>"success",
            "message"=>"None",
            "redirect"=>$redirect
            ])
        );
        exit();
    }
    public function register(string $correo, string $nombre, string $psw, bool $validEmail=FALSE){
        if ($validEmail)
        {
            $correo=strtolower($correo);
            if (filter_var($correo,FILTER_VALIDATE_EMAIL))
            {
                if (!self::accountExists($correo))
                {
                    print_r(json_encode([
                        "email"=>"valid"
                    ]));
                }else
                {
                    print_r(json_encode([
                        "email"=>"used",
                        "message"=>"email already used"
                    ]));
                }
            }else{
                print_r(json_encode([
                    "status"=>"wait"
                ]));
            }
            exit();
        }
        if ($this->validarSesion())
        {
            print_r(
                json_encode([
                    "status"=>"failed",
                    "message"=>"sesion almost exist",
                    "redirect"=>"index.php"
                    ])
                );
            exit();
        }
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL))
        {
            session_destroy();
            print_r(json_encode([
                "status"=>"failed",
                "message"=>"El correo proporcionado no es valido",
                "inputError"=>"correo"
                ])
            );
            exit();
        }
        if (self::accountExists($correo)){
            print_r(json_encode([
                "status"=>"failed",
                "message"=>"Email already used",
                "inputError"=>"correo"
            ]));
            exit();
        }
        if (strlen($psw)<8){
            print_r(json_encode([
                "status"=>"failed",
                "message"=>"La contraseña debe ser de al menos 8 caracteres",
                "inputError"=>"psw"
            ]));
            exit();
        }
        $nombre=filter_var($nombre,FILTER_SANITIZE_SPECIAL_CHARS);
        if (strlen($nombre)<3){
            print_r(json_encode([
                "status"=>"failed",
                "message"=>"Tu nombre debe ser de al menos 3 caracteres",
                "inputError"=>"nombreUsuario"
            ]));
            exit();
        }
        $psw=password_hash(filter_var($psw,FILTER_SANITIZE_FULL_SPECIAL_CHARS),PASSWORD_DEFAULT);
        if (Usuarios::registrarUsuario($correo,$nombre,$psw)){
            print_r(json_encode([
                "status"=>"success",
                "message"=>"Se ha creado tu cuenta, seras redirigido al inicio de sesión",
                "redirect"=>"login.php"
            ]));
            exit();
        }
    }
    private function accountExists(string $correo){
        $conexion = BDconection::conectar("user");
        $sql="SELECT COUNT(*) as cont
            FROM usuario
            WHERE correo=:correo";
        $query=$conexion->prepare($sql);
        $query->execute([":correo"=>$correo]);
        if ($result=$query->fetch()){
            if ($result["cont"]==1)
                return TRUE;
        }
        return FALSE;
    }
    public function predictTematica(string $tematica):array{
        if (!filter_var($tematica,FILTER_SANITIZE_SPECIAL_CHARS))
            return [];
        $conexion=BDconection::conectar(("user"));
        $sql="SELECT 
            nombreTem as nombre
            FROM tematica
            WHERE
            estado=1 AND
            (nombreTem LIKE CONCAT(:tematica,'%') 
            OR descr LIKE CONCAT(:descripcion,'%'))";
        $query=$conexion->prepare($sql);
        $query->bindParam(":tematica",$tematica);
        $query->bindParam(":descripcion",$tematica);
        $query->execute();
        if ($result=$query->fetchAll()){
            // print_r(json_encode($result));
            // exit();
            return $result;
        }
        return [];
    }
    public function predictLocalidad(string $localidad):array{
        if (!filter_var($localidad,FILTER_SANITIZE_SPECIAL_CHARS))
            return [];
        $conexion=BDconection::conectar(("user"));
        $sql="SELECT 
            CONCAT_WS(', ',
                nombreLoc,
                nombreProv,
                nombrePais) as nombre
            FROM localidad
            WHERE
            nombreLoc LIKE CONCAT(:localidad,'%')";
        $query=$conexion->prepare($sql);
        $query->bindParam(":localidad",$localidad);
        $query->execute();
        if ($result=$query->fetchAll()){
            print_r(json_encode($result));
            exit();
            return $result;
        }
        return [];
    }
    public function predictDestino(string $destino):array{
        if (!filter_var($destino,FILTER_SANITIZE_SPECIAL_CHARS))
            return [];
        $conexion=BDconection::conectar(("user"));
        $sql="SELECT 
            nombreDest as nombre
            FROM destino
            WHERE
            estado=1 AND
            nombreDest LIKE CONCAT(:destino,'%')";
        $query=$conexion->prepare($sql);
        $query->bindParam(":destino",$destino);
        $query->execute();
        if ($result=$query->fetchAll()){
            print_r(json_encode($result));
            exit();
            return $result;
        }
        return [];
    }
    public function renderError(){
        echo "ocurrio un error, intente de nuevo mas tarde";
    }
    public function crearPeticion(array $datos, array $imagenes):bool{
        if ($id=Peticiones::crearPeticion($datos["titulo"],$datos["cuerpo"],$datos["destino"],$datos["localidad"]/*,intval($datos["objetivo"])*/)){
            Peticiones::agregarTematicas($id,array_unique($datos["tematicas"]));
            Imagenes::subirImagenesPeticion($id,$imagenes);
            // $_SESSION["usuario"]->getUsuario()->sumarValoracion(15);
            return TRUE;
        }else{
            // $this->renderError();
            return FALSE;
        }
    }
    public function evaluarEstadoRedaccion(){
        if (isset($_POST["get_data"]))
        {
            if (isset($_POST["tematica"]))
            {
                $aux=strtolower($_POST["tematica"]);
                print_r(json_encode($this->predictTematica($_POST["tematica"]))) ;
                exit();
            }
            else if (isset($_POST["localidad"]))
            {
                $aux=strtolower($_POST["localidad"]);
                print_r(json_encode($this->predictLocalidad($_POST["localidad"]))) ;
                exit();
            }
            else if (isset($_POST["destino"]))
            {
                $aux=strtolower($_POST["destino"]);
                print_r(json_encode($this->predictDestino($_POST["destino"]))) ;
                exit();
            }
            else if (isset($_POST["cuerpo"]))
            {
                // print_r($_POST);
                // $textoFormal = $this->generateFormalText("Escribe una carta formal de reclamo, junto con un titulo para la misma, basada en la siguiente descripción: {$_POST['cuerpo']}");
                // print_r(json_encode([$textoFormal]));
                exit();
            }
        }else if (isset($_POST["cuerpo"]) && isset($_POST["titulo"]) /*&& isset($_POST["objetivo"])*/ && isset($_POST["localidad"]) && isset($_POST["destino"]) && isset($_POST["tematicas"]) && isset($_FILES["imagenes"])){
            if ($_POST["titulo"]=="" || strlen($_POST["titulo"])<10)
            {
                print_r(json_encode([
                    "status"=>"failed",
                    "message"=>"El titulo de la peticion debe ser mas largo",
                    "inputError"=>"titulo-input",
                    "etapa"=>1
                ]));
                exit();
            }
            if (strlen($_POST["titulo"])>100)
            {
                print_r(json_encode([
                    "status"=>"failed",
                    "message"=>"El titulo de la peticion debe ser mas corto",
                    "inputError"=>"titulo-input",
                    "etapa"=>1
                ]));
                exit();
            }
            if (strlen($_POST["cuerpo"])<20)
            {
                print_r(json_encode([
                    "status"=>"failed",
                    "message"=>"El cuerpo de la peticion debe ser mas largo",
                    "inputError"=>"cuerpo-input",
                    "etapa"=>1
                ]));
                exit();
            }
            // if (intval($_POST["objetivo"]<=100))
            // {
            //     print_r(json_encode([
            //         "status"=>"failed",
            //         "message"=>"El objetivo de firmas debe ser mayor a 100",
            //         "inputError"=>"objetivo-input",
            //         "etapa"=>2
            //     ]));
            //     exit();
            // }
            if (!is_array($_POST["tematicas"]) || !is_array($_FILES["imagenes"]))
            {
                print_r(json_encode([
                    "status"=>"failed",
                    "message"=>"Ocurrio un error inesperado",
                    // "inputError"=>"temati-input",
                    "redirect"=>"index.php"
                ]));
                exit();
            }
            // Agregar una variable de sesion que le impida subir automaticamente otra peticion en caso de que manipulen el js desde el inspector de elementos.
            if ($this->crearPeticion($_POST,$_FILES["imagenes"])){
                print_r(json_encode([
                    "status"=>"success",
                    "message"=>"Peticion creada correctamente",
                    "redirect"=>"index.php"
                ]));
                exit();
            }
            else {
                print_r(json_encode([
                    "status"=>"Failed",
                    "message"=>"Ocurrio un error inesperado",
                    "redirect"=>"index.php"
                ]));
                exit();
            }
        }
        // print_r(json_encode($_POST));
        //     exit();
        // else{
        //     print_r($_POST);
        //     print_r($_FILES);
        //     exit();
        // }

    }
    public function renderTemplate(string $archivo, array $variables =[]){
        if (file_exists("../app/views/plantillas/".$archivo)){
            extract($variables); // Extrae las variables del array asociativo
            include("../app/views/plantillas/".$archivo);
        }
        else echo "el archivo no existe";
    }
    // public function getTemplate(string $archivo){
    //     if (file_exists("../app/views/plantillas/".$archivo)){
    //         return ("../app/views/plantillas/".$archivo);
    //     }
    //     else return "el archivo no existe";
    // }
    public function renderFormularioPeticion(){
        $template="peticion.php";
            $this->renderTemplate($template);
    }
    // IA text generation
    // public function generateFormalText($prompt) {
    //     $openai_key = getenv('OPENAI_API_KEY');
        
        
    //     $data = [
    //         'model' => 'gpt-4o-mini',  // Especifica el modelo GPT-4
    //         'messages' => [
    //             [
    //                 'role' => 'user',
    //                 'content' => $prompt
    //             ]
    //         ],
    //         'max_tokens' => 150,
    //         'n' => 1,
    //         'stop' => ["\n"]
    //     ];
    
    //     $ch = curl_init();
        
    //     curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/chat/completions'); // Endpoint para el modelo GPT-4
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //     curl_setopt($ch, CURLOPT_POST, 1);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, [
    //         'Authorization: Bearer ' . $openai_key,
    //         'Content-Type: application/json'
    //     ]);
        
    //     $response = curl_exec($ch);
    //     if (curl_errno($ch)) {
    //         echo 'Error:' . curl_error($ch);
    //     }
    //     curl_close($ch);
        
    //     $data = json_decode($response, true);
        
    //     // Depuración: imprimir la respuesta de la API
    //     print_r($data);
    //     exit();
    
    //     return $data['choices'][0]['message']['content'];
    // }
    public function evaluarIndexRequest(){
        if (isset($_POST))
        {
            if (isset($_POST["firmar"]))
            {
                
                $peticion=intval($_POST["firmar"]);
                if ($peticion<=0)
                    exit();
                if (Peticiones::peticionExiste($peticion))
                {
                    if (!$this->validarSesion())
                    {
                        $_SESSION["redirect"]="search.php?petition=$peticion";
                        $this->jsonAndExit("no sesion","",["redirect"=>"login.php"]);

                    }

                    // Uncomment below and comment the <if> statement over here to
                    // add Sign without sesion functionality  

                    // $requestComeFrom = $_SERVER["HTTP_REFERER"];
                    // $requestComeFrom = explode('/',$requestComeFrom);
                    // $requestComeFrom = array_pop($requestComeFrom);
                    // if (!$this->validarSesion())
                    // {
                    //     // verifica que la peticion viene desde la pagina de busqueda
                    //     // suponiendo que la persona ve la peticion porque alguien se la compartió
                    //     if(preg_match('/^search\.php\?petition=\d+$/', $requestComeFrom))
                    //     {
                    //         if (!isset($_SESSION["forzarFirma"]))
                    //         {
                    //             $_SESSION["forzarFirma"]=true;
                    //             $this->jsonAndExit("no sesion","Vemos que no has iniciado sesión. Quieres continuar sin registrarte?",["redirect"=>"login.php"]);
                    //         }
                    //     }
                    //     else
                    //     {
                    //         $_SESSION["redirect"]="search.php?petition=".$peticion;
                    //         print_r(json_encode([
                    //             "status"=>"no sesion",
                    //             "redirect"=>"login.php"
                    //         ]));
                    //         exit();
                    //     }
                    // }
                    // agregar en las respuestas, el texto que contenga el valor del algoritmo para mostrar el numero de firmas hechas y objetivo
                    // if (isset($_SESSION["forzarFirma"]))
                    // {
                    //     if (Firmas::firmaExiste($peticion,$_SESSION["usuario"]->getIP(),"ip"))
                    //     {
                    //         unset($_SESSION["forzarFirma"]);

                    //         if (Firmas::quitarFirma($peticion,$_SESSION["usuario"]->getIP(),"ip"))
                    //         {
                    //             print_r(json_encode([
                    //                 "status"=>"success",
                    //                 "message"=>"firma eliminada",
                    //                 "firmas"=>-1
                    //             ]));
                    //             // Peticiones::verificarEstado($peticion);
                    //             exit();
                    //         }else
                    //         {
                    //             print_r(json_encode([
                    //                 "status"=>"failed",
                    //                 "message"=>"no se pudo eliminar la firma"
                    //             ]));
                    //             exit();
                    //         }
                    //     }
                    //     else if(isset($_POST["comentario"]) && isset($_POST["anonimo"])){
                    //         unset($_SESSION["forzarFirma"]);
                    //         $comentario=filter_var($_POST["comentario"],FILTER_SANITIZE_SPECIAL_CHARS);
                    //         $anonimo=intval($_POST["anonimo"]);
                    //         if ($anonimo<0 || $anonimo>1){
                    //             print_r(json_encode([
                    //                 "status"=>"failed",
                    //                 "message"=>"datos no validos"
                    //             ]));
                    //             exit();
                    //         }
                    //         if(!controladorIPs::IPExiste($_SESSION["usuario"]->getIP())){
                    //             controladorIPs::insertarIP($_SESSION["usuario"]->getIP());
                    //         }
                    //         if (Firmas::crearFirma($peticion,$_SESSION["usuario"]->getIP(),"ip",$comentario,$anonimo))
                    //         {
                    //             print_r(json_encode([
                    //                 "status"=>"success",
                    //                 "message"=>"firmado correctamente",
                    //                 "firmas"=>1
    
                    //             ]));
                    //             // Peticiones::verificarEstado($peticion);
                    //             exit();
                    //         }else
                    //         {
                    //             print_r(json_encode([
                    //                 "status"=>"failed",
                    //                 "message"=>"no se pudo crear la firma"
                    //             ]));
                    //             exit();
                    //         }
                    //     }else
                    //     {
                    //         print_r(json_encode([
                    //             "status"=>"wait"
                    //         ]));
                    //         exit();
                    //     }
                    // }
                    // else
                    {
                        if (Firmas::firmaExiste($peticion,$_SESSION["usuario"]->getUsuario()->getCorreo(),"correo"))
                        {
                            if (Firmas::quitarFirma($peticion,$_SESSION["usuario"]->getUsuario()->getCorreo(),"correo"))
                            {
                                print_r(json_encode([
                                    "status"=>"success",
                                    "message"=>"firma eliminada",
                                    "firmas"=>-1
                                ]));
                                // Peticiones::verificarEstado($peticion);
                                exit();
                            }else
                            {
                                print_r(json_encode([
                                    "status"=>"failed",
                                    "message"=>"no se pudo eliminar la firma"
                                ]));
                                exit();
                            }
                        }
                        else if(isset($_POST["comentario"]) && isset($_POST["anonimo"])){
                            $comentario=filter_var($_POST["comentario"],FILTER_SANITIZE_SPECIAL_CHARS);
                            $anonimo=intval($_POST["anonimo"]);
                            if ($anonimo<0 || $anonimo>1){
                                print_r(json_encode([
                                    "status"=>"failed",
                                    "message"=>"datos no validos"
                                ]));
                                exit();
                            }
                            if (Firmas::crearFirma($peticion,$_SESSION["usuario"]->getUsuario()->getCorreo(),"correo",$comentario,$anonimo))
                            {
                                Peticiones::evaluarObjetivo($peticion);
                                print_r(json_encode([
                                    "status"=>"success",
                                    "message"=>"firmado correctamente",
                                    "firmas"=>1
    
                                ]));
                                // Peticiones::verificarEstado($peticion);
                                exit();
                            }else
                            {
                                print_r(json_encode([
                                    "status"=>"failed",
                                    "message"=>"no se pudo crear la firma"
                                ]));
                                exit();
                            }
                        }else
                        {
                            print_r(json_encode([
                                "status"=>"wait"
                            ]));
                            exit();
                        }
                    }
                }
            }
        }
        if (isset($_GET))
        {
            if (isset($_GET["getPeticiones"]))
            {
                $cant=intval($_GET["getPeticiones"]);
                if ($cant<=0) exit();
                if (!$this->validarSesion())
                {
                    print_r(json_encode([
                        "status"=>"no sesion",
                        "redirect"=>"login.php"
                    ]));
                    exit();
                }
                $this->displayPetitions($cant,TRUE);
                exit();

            }
            if (isset($_GET["verFirmas"]) && isset($_GET["limite"]))
            {
                $peticion=intval($_GET["verFirmas"]);
                $limite=intval($_GET["limite"]);
                if ($peticion<=0 || $limite<0)
                    exit();
                if (Peticiones::peticionExiste($peticion))
                {
                    if (!$this->validarSesion())
                    {
                        $_SESSION["redirect"]="search.php?petition=".$peticion;
                        print_r(json_encode([
                            "status"=>"no sesion",
                            "redirect"=>"login.php"
                        ]));
                        exit();
                    }
                    if ($firmas=Firmas::mostrarFirmas($peticion,$limite))
                    {
                        print_r(json_encode([
                            "status"=>"success",
                            "firmas"=>$firmas
                        ]));
                        exit();
                    }
                    else
                    {
                        print_r(json_encode([
                            "status"=>"success",
                            "firmas"=>[]
                        ]));
                        exit();
                    }

                }
            }
        }

    }
    public function mostrarPeticion(int $nroPet){
        if ($nroPet<=0){
            $this->renderError();
            return;
        }else{
            if (($peticion = Peticiones::getPeticionByNumero($nroPet)) && $peticion->esMostrable()){
                if ($this->validarSesion())
                    echo $peticion->mostrarPeticion(Firmas::firmaExiste($nroPet,$_SESSION["usuario"]->getUsuario()->getCorreo(),"correo"));
                else
                    $this->renderNoProfile();
                    // else{
                //     $usuario=new WebUser();
                //     $_SESSION["usuario"]=$usuario;
                //     echo $peticion->mostrarPeticion(Firmas::firmaExiste($nroPet,$usuario->getIP(),"ip"));
                // }
            }
        }
    }
    public function busqueda(string $busqueda){
        $peticiones=Peticiones::buscarPeticiones($busqueda);
        foreach ($peticiones as $peticion)
        {
            echo $peticion;
        }
        echo "
        <div class='is-centered'>
            <button class='button is-rounded load-more-pet' type='button' id='load-more-search'>+</button>
        
        </div>";
    }
    public function evaluarSearchRequest() {
        
        if ($this->validarSesion())
        {
            
            if (isset($_GET["search"]) && isset($_GET["limite"]))
            {
                $busqueda=filter_var($_GET["search"],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $limite=intval($_GET["limite"]);
                
                if ($limite>0)
                {
                    
                    $peticiones=Peticiones::buscarPeticiones($busqueda,$limite);
                    if (count($peticiones)>0)
                    {
                        // $peticiones[].=Peticiones::loadMorePetitionsButton();
                        print_r(json_encode([
                            "status"=>"success",
                            "peticiones"=>$peticiones
                        ]));
                        exit();
                    }else
                    {
                        print_r(json_encode([
                            "status"=>"wait",
                            "message"=>"No hay mas coincidencias"
                        ]));
                        exit();
                    }
                }
                print_r(json_encode([
                    "status"=>"wait",
                    "message"=>"No hay coincidencias"
                ]));
                exit();
            }

        }
        return;
        
    }
    public function mostrarFirmas(int $nroPet){
        if ($nroPet>0)
            print_r(json_encode(Firmas::mostrarFirmas($nroPet)));
        exit();
    }
    public function validarAdmin(){
        if (!$this->validarSesion()) return FALSE;
        if (!$_SESSION["usuario"]->isAdmin()) return FALSE;
        // if ($_SESSION["admin"]!=TRUE) return FALSE;
        return TRUE;
    }
    public function renderOptions(array $opciones){
        foreach ($opciones as $opcion)
        {
            echo $this->option($opcion["icono"],$opcion["texto"],$opcion["id"],$opcion["link"]);

        }
        // echo $this->option("interests","Administrar Intereses","","options.php?page=administrar_intereses");
        // echo $this->option("edit","Editar Perfil","edit","options.php?page=administrar_perfil");
        // echo $this->option("exit","Cerrar sesión","logout","");
    }
    public function option(string $icono,string $text,string $id,string $link=""):string{
        $tema=(isset($_COOKIE["theme"]) && $_COOKIE["theme"]=="light") ? "light" : "dark";

        if ($link=="")
        {
            $div="
        <div class='option' id='{$id}'>
            <div class='option-icon'>
                {$this->getIcono($icono,$tema)}
            </div>
            <div class='option-text'>
                <p>{$text}</p>
            </div>
        </div>";
        }else{
            $div="
        <a href='{$link}'>
            <div class='option' id='{$id}'>
                <div class='option-icon'>
                    {$this->getIcono($icono,$tema)}
                </div>
                <div class='option-text'>
                    <p>{$text}</p>
                </div>
            </div>
        </a>";

        }
        return $div;
    }
    private function jsonAndExit(string $status="error", string $msg="", array $options=[]){
        $arr=[
            "status"=>$status,
            "message"=>$msg
        ];
        foreach ($options as $key => $value)
        {
            $arr[$key]=$value;
        }
        print_r(json_encode($arr));
        exit();
    }
    public function validarModer(){
        if (!$this->validarSesion()) return FALSE;
        if (!$_SESSION["usuario"]->isModer()) return FALSE;
        // if ($_SESSION["admin"]!=TRUE) return FALSE;
        return TRUE;
    }
    public function renderContenidoOptions(){
        if (!$this->validarSesion()) $this->renderNoProfile();
        else
        {
            if ($this->validarAdmin() && isset($_GET["mode"]) && $_GET["mode"]=="admin" && isset($_GET["page"]))
            {
                $page=filter_var($_GET["page"],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                if ($page=="peticiones_finalizadas")
                {
                    Peticiones::mostrarPeticionesFinalizadas();
                }
                if ($page=="usuarios")
                {
                    $this->renderTemplate("cabeceraUsuariosAdmin.php");
                    // Usuarios::gestionarUsuarios();
                }
                if ($page=="informes")
                {
                    $this->renderTemplate("cabeceraInformesAdmin.php");
                    // Usuarios::gestionarUsuarios();
                }
            }
            if ($this->validarModer() && isset($_GET["mode"]) && $_GET["mode"]=="admin" && isset($_GET["page"]))
            {
                $page=filter_var($_GET["page"],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                if ($page=="peticiones_nuevas")
                {
                    Peticiones::mostrarPeticionesNuevas();
                }
                if ($page=="tematicas")
                {
                    $this->renderTemplate("cabeceraTematicasAdmin.php");
                    if (isset($_GET["tematicas"]) && ($_GET["tematicas"]=="nuevas" || $_GET["tematicas"]=="existentes"))
                        Tematicas::mostrarTematicasAdmin($_GET["tematicas"]);         
                    else if (isset($_GET["tematicas"]) && ($_GET["tematicas"]=="agregar"))
                        $this->renderTemplate("formularioTematica.php");
                    else if (isset($_GET["tematicas"]) && ($_GET["tematicas"]=="instrucciones"))
                        $this->renderTemplate("instrucciones.php");
                }
                if ($page=="destinos")
                {
                    $this->renderTemplate("cabeceraDestinosAdmin.php");
                    if (isset($_GET["destinos"]) && ($_GET["destinos"]=="nuevos" || $_GET["destinos"]=="existentes"))
                        Destinos::mostrarDestinosAdmin($_GET["destinos"]);         
                    else if (isset($_GET["destinos"]) && ($_GET["destinos"]=="agregar"))
                        $this->renderTemplate("formularioDestino.php");
                    else if (isset($_GET["destinos"]) && ($_GET["destinos"]=="instrucciones"))
                        $this->renderTemplate("instrucciones.php");
                }
                if ($page=="localidades")
                {
                    $this->renderTemplate("cabeceraLocalidadesAdmin.php");
                    if (isset($_GET["localidades"]) && ($_GET["localidades"]=="nuevas" || $_GET["localidades"]=="existentes"))
                        Localidades::mostrarLocalidadesAdmin($_GET["localidades"]);         
                    else if (isset($_GET["localidades"]) && ($_GET["localidades"]=="agregar"))
                        $this->renderTemplate("formularioLocalidad.php");
                    else if (isset($_GET["localidades"]) && ($_GET["localidades"]=="instrucciones"))
                        $this->renderTemplate("instrucciones.php");
                }
            }
            else if (isset($_GET["page"]))
            {
                $page=filter_var($_GET["page"],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                if ($page=="administrar_perfil")
                {
                    $_SESSION["usuario"]->administrarPerfil();
                }
                if ($page=="intereses")
                {
                    $this->renderTemplate("formularioIntereses.php");
                    echo $_SESSION["usuario"]->getUsuario()->misIntereses();
                }
                if ($page=="mis_peticiones")
                {
                    echo $_SESSION["usuario"]->getUsuario()->misPeticionesFinalizadas();
                }
                
            }
            else
            {
                // if ($this->validarAdmin())
                //     $this->renderAdminOptions();
                $this->renderOptions($_SESSION["usuario"]->getUsuario()->opciones());
                

            }
        }
    }
    public function validarOptionsRequest(){
        if ($this->validarAdmin() && isset($_GET["mode"]) && $_GET["mode"]=="admin" && isset($_GET["page"]))
        {     
            if (isset($_POST["peticion"]))
            {
                $page=filter_var($_GET["page"],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $peticion=intval($_POST["peticion"]);
                if ($peticion<=0) exit();
                if ($page=="alta") {
                    // poner estado 0 a la peticion
                    if (Peticiones::alta($peticion))
                    {
                        print_r(json_encode([
                            "status"=>"success",
                            "message"=>"Peticion dada de alta"
                        ]));
                        exit();
                    }else{
                        print_r(json_encode([
                            "status"=>"failed",
                            "message"=>"error inesperado"
                        ]));
                        exit();
                    }
                }
                if ($page=="baja") {
                    // poner estado -2 a la peticion con el motivo de poder ver las peticiones eliminadas en algun momento
                    if (Peticiones::baja($peticion))
                    {
                        print_r(json_encode([
                            "status"=>"success",
                            "message"=>"Peticion dada de baja"
                        ]));
                        exit();
                    }else{
                        print_r(json_encode([
                            "status"=>"failed",
                            "message"=>"error inesperado"
                        ]));
                        exit();
                    }
                }
                if ($page=="pdf") {
                    // poner estado -2 a la peticion con el motivo de poder ver las peticiones eliminadas en algun momento
                    if (Peticiones::admitirPDF($peticion))
                    {
                        print_r(json_encode([
                            "status"=>"success",
                            "message"=>"Peticion habilitada para PDF"
                        ]));
                        exit();
                    }else{
                        print_r(json_encode([
                            "status"=>"failed",
                            "message"=>"error inesperado"
                        ]));
                        exit();
                    }
                }
                if ($page=="editar") {
                    // poner estado -2 a la peticion con el motivo de poder ver las peticiones eliminadas en algun momento
                    print_r(json_encode($_POST));
                    exit();
                }
            }else if ($_GET["page"]=="tematicas")
            {
                if (isset($_POST["admitir"]))
                {
                    $tematicaAdmitir=strtolower(filter_var($_POST["admitir"],FILTER_SANITIZE_FULL_SPECIAL_CHARS));
                    if (!Tematicas::tematicaExiste($tematicaAdmitir))
                        $this->jsonAndExit();
                    if (isset($_POST["combinarCon"]))
                    {
                        $combinar=strtolower(filter_var($_POST["combinarCon"],FILTER_SANITIZE_FULL_SPECIAL_CHARS));
                        if (!Tematicas::tematicaExiste($combinar))
                            $this->jsonAndExit();
                        if(Tematicas::combinarTematica($tematicaAdmitir,$combinar))
                        {
                            print_r(json_encode([
                                "status"=>"success"
                            ]));
                            exit();
                        }
                    }
                    else
                    {
                        if(Tematicas::admitirTematica($tematicaAdmitir))
                        {
                            print_r(json_encode([
                                "status"=>"success"
                            ]));
                            exit();
                        }
                    }
                    $this->jsonAndExit();
                    exit();
                }
                else if (isset($_POST["eliminar"]))
                {
                    $tematica=strtolower(filter_var($_POST["eliminar"],FILTER_SANITIZE_FULL_SPECIAL_CHARS));
                    if (Tematicas::tematicaExiste($tematica))
                    {
                        if(Tematicas::eliminarTematica($tematica));
                            $this->jsonAndExit("success");
                        $this->jsonAndExit("error");
                    }
                }
                else if (isset($_POST["nombreTematica"]) && isset($_POST["descripcionTematica"])) 
                {
                    $tematica=strtolower(filter_var($_POST["nombreTematica"],FILTER_SANITIZE_FULL_SPECIAL_CHARS));
                    $descripcion=filter_var($_POST["descripcionTematica"],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    if ($tematica=="" || strlen($tematica)<4)
                        $this->jsonAndExit("failed","El nombre de la tematica es muy corto",["inputError"=>"nombreTematica"]);
                    if (Tematicas::tematicaExiste($tematica))
                        $this->jsonAndExit("failed","tematica ya existe",["inputError"=>"nombreTematica"]);
                    if ($descripcion=="" || strlen($descripcion)<10)
                        $this->jsonAndExit("failed","la descripcion de la tematica es muy corta",["inputError"=>"descripcionTematica"]);
                    if (Tematicas::crearTematica($tematica,$descripcion))
                    {
                        $this->jsonAndExit("success");
                    }
                    $this->jsonAndExit("error inesperado");
                    exit();
                }
            }else if ($_GET["page"]=="destinos")
            {
                if (isset($_POST["admitir"]))
                {
                    $destinoAdmitir=strtolower(filter_var($_POST["admitir"],FILTER_SANITIZE_FULL_SPECIAL_CHARS));
                    if (!Destinos::destinoExiste($destinoAdmitir))
                        $this->jsonAndExit();
                    if (isset($_POST["combinarCon"]))
                    {
                        $combinar=strtolower(filter_var($_POST["combinarCon"],FILTER_SANITIZE_FULL_SPECIAL_CHARS));
                        if (!Destinos::destinoExiste($combinar))
                            $this->jsonAndExit();
                        if(Destinos::combinarDestino($destinoAdmitir,$combinar))
                        {
                            print_r(json_encode([
                                "status"=>"success"
                            ]));
                            exit();
                        }
                    }
                    else
                    {
                        if(Destinos::admitirDestino($destinoAdmitir))
                        {
                            print_r(json_encode([
                                "status"=>"success"
                            ]));
                            exit();
                        }
                    }
                    $this->jsonAndExit();
                    exit();
                }
                else if (isset($_POST["eliminar"]))
                {
                    $destino=strtolower(filter_var($_POST["eliminar"],FILTER_SANITIZE_FULL_SPECIAL_CHARS));
                    if (Destinos::destinoExiste($destino))
                    {
                        if(Destinos::eliminarDestino($destino));
                            $this->jsonAndExit("success");
                        $this->jsonAndExit("error");
                    }
                }
                else if (isset($_POST["nombreDestino"]) && isset($_POST["descripcionDestino"])) 
                {
                    $destino=strtolower(filter_var($_POST["nombreDestino"],FILTER_SANITIZE_FULL_SPECIAL_CHARS));
                    $descripcion=strtolower(filter_var($_POST["descripcionDestino"],FILTER_SANITIZE_FULL_SPECIAL_CHARS));
                    if ($destino=="" || strlen($destino)<4)
                        $this->jsonAndExit("failed","El nombre del destino es muy corto",["inputError"=>"nombreDestino"]);
                    if (Destinos::destinoExiste($destino))
                        $this->jsonAndExit("failed","destino ya existe",["inputError"=>"nombreDestino"]);
                    if ($descripcion=="" || strlen($descripcion)<10)
                        $this->jsonAndExit("failed","la descripcion del destino es muy corta",["inputError"=>"descripcionDestino"]);
                    if (Destinos::crearDestino($destino,$descripcion))
                    {
                        $this->jsonAndExit("success");
                    }
                    $this->jsonAndExit("error inesperado");
                    exit();
                }
            }else if ($_GET["page"]=="localidades")
            {
                if (isset($_POST["admitir"]))
                {
                    $localidadAdmitir=strtolower(filter_var($_POST["admitir"],FILTER_SANITIZE_FULL_SPECIAL_CHARS));

                    // $this->jsonAndExit("error1",$localidadAdmitir);
                    if (!Localidades::localidadExiste($localidadAdmitir))
                        $this->jsonAndExit("$localidadAdmitir");
                    if (isset($_POST["combinarCon"]))
                    {
                        $combinar=strtolower(filter_var($_POST["combinarCon"],FILTER_SANITIZE_FULL_SPECIAL_CHARS));
                        if (!Localidades::localidadExiste($combinar))
                            $this->jsonAndExit();
                        if(Localidades::combinarLocalidad($localidadAdmitir,$combinar))
                        {
                            $this->jsonAndExit("success");
                        }
                    }
                    else
                    {
                        if(Localidades::admitirLocalidad($localidadAdmitir))
                        {
                            $this->jsonAndExit("success");
                        }
                    }
                    $this->jsonAndExit();
                    exit();
                }
                else if (isset($_POST["eliminar"]))
                {
                    $localidad=strtolower(filter_var($_POST["eliminar"],FILTER_SANITIZE_FULL_SPECIAL_CHARS));
                    if (Localidades::localidadExiste($localidad))
                    {
                        if(Localidades::eliminarLocalidad($localidad))
                            $this->jsonAndExit("success");
                        $this->jsonAndExit("error");
                    }
                }
                else if (isset($_POST["nombreLocalidad"]) && isset($_POST["nombreProvincia"]) && isset($_POST["nombrePais"])) 
                {
                    // $this->jsonAndExit("hola");
                    try {
                        $localidad=strtolower(filter_var($_POST["nombreLocalidad"],FILTER_SANITIZE_FULL_SPECIAL_CHARS));
                        $provincia=strtolower(filter_var($_POST["nombreProvincia"],FILTER_SANITIZE_FULL_SPECIAL_CHARS));
                        $pais=strtolower(filter_var($_POST["nombrePais"],FILTER_SANITIZE_FULL_SPECIAL_CHARS));
                    } catch (Exception $e) {
                        return FALSE;
                    }
                    if (!Paises::paisExiste($pais))
                        $this->jsonAndExit("failed","El Pais no existe",["inputError"=>"nombrePais"]);
                    if (!Provincias::provinciaExiste($pais,$provincia))
                        $this->jsonAndExit("failed","La provincia no existe",["inputError"=>"nombreProvincia"]);
                    if ($localidad=="" || strlen($localidad)<4)
                        $this->jsonAndExit("failed","El nombre del localidad es muy corto",["inputError"=>"nombreLocalidad"]);
                    if (Localidades::localidadExiste($localidad))
                        $this->jsonAndExit("failed","localidad ya existe",["inputError"=>"nombreLocalidad"]);
                    $localidad.=", ".$provincia.", ".$pais;
                    if (Localidades::crearLocalidad($localidad))
                    {
                        $this->jsonAndExit("success");
                    }
                    $this->jsonAndExit("error inesperado");
                    exit();
                }
            }else if ($_GET["page"]=="usuarios")
            {
                if(isset($_GET["search"]) && strlen($_GET["search"])>0)
                {
                    $busqueda=strtolower(filter_var($_GET["search"],FILTER_SANITIZE_FULL_SPECIAL_CHARS));
                    $usuarios=Usuarios::getUsuariosAdmin($busqueda);
                    $this->jsonAndExit("success","",["usuarios"=>$usuarios]);
                }
                else if (isset($_POST["rol"]) && isset($_POST["correo"]))
                {
                    try{
                        $correo=strtolower(filter_var($_POST["correo"],FILTER_SANITIZE_EMAIL));
                        $rol=strtolower(filter_var($_POST["rol"],FILTER_SANITIZE_FULL_SPECIAL_CHARS));
                        if ($rol!="moderador" && $rol!="admin" && $rol!="user")
                            $this->jsonAndExit();
                        if(Usuarios::asignarRol($rol,$correo))
                            $this->jsonAndExit("success");
                    }catch(Exception $e)
                    {
                        $this->jsonAndExit($e->getMessage());
                    }
                }
            }elseif ($_GET["page"]=="informes") 
            {
                if (isset($_GET["opcion"]))
                {
                    $opcion=filter_var($_GET["opcion"],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    require_once "../app/controllers/controladorInformes.php";
                    if ($opcion=="mensual")
                    {
                        if (isset($_GET["fecha1"]))
                        {
                            if(!(preg_match('/^\d{4}-(0[1-9]|1[0-2])$/',$_GET["fecha1"])))
                                $this->jsonAndExit("error","debe ingresar una fecha valida",["inputError"=>"fechaInput"]);
                            [$ano,$mes]=explode("-",$_GET["fecha1"]);
                            if($informe=Informes::getInforme($ano,$mes))
                            {   
                                $this->jsonAndExit("success","",["result"=>Informes::mostrarInforme($informe)]);
                            }
                            $this->jsonAndExit("no result","No hay ningun resultado sobre esta fecha");
                        }
                    }
                    if ($opcion=="anual")
                    {
                        if (isset($_GET["fecha1"]))
                        {
                            if (!(preg_match('/^\d{4}$/',$_GET["fecha1"])))
                                $this->jsonAndExit("error","debe ingresar una fecha valida",["inputError"=>"fechaInput"]);
                            $ano=intval($_GET["fecha1"]);
                            if ($ano<2024 || $ano>date("Y"))
                                $this->jsonAndExit("error","debe ingresar un año entre 2024 y ".date("Y"),["inputError"=>"fechaInput"]);

                            if($informe=Informes::getInformeAnual($ano))
                            {
                                $this->jsonAndExit("success","",["result"=>Informes::mostrarInforme($informe,"anual")]);
                            }
                            $this->jsonAndExit("no result","No hay ningun resultado sobre esta fecha");
                        }
                    }
                    if ($opcion=="comparar")
                    {
                        if (isset($_GET["fecha1"]) && isset($_GET["fecha2"]))
                        {
                            if (!(preg_match('/^\d{4}-(0[1-9]|1[0-2])$/',$_GET["fecha1"])))
                                $this->jsonAndExit("error","debe ingresar una fecha valida",["inputError"=>"fechaInput1"]);
                            if (!(preg_match('/^\d{4}-(0[1-9]|1[0-2])$/',$_GET["fecha2"])))
                                $this->jsonAndExit("error","debe ingresar una fecha valida",["inputError"=>"fechaInput2"]);
                            [$ano1,$mes1]=explode("-",$_GET["fecha1"]);
                            [$ano2,$mes2]=explode("-",$_GET["fecha2"]);
                            if(($informe1=Informes::getInforme($ano1,$mes1)) && ($informe2=Informes::getInforme($ano2,$mes2)))
                            {
                                $this->jsonAndExit("success","",["result"=>Informes::compararInformes($informe1,$informe2)]);
                            }
                            $this->jsonAndExit("no result","No hay ningun resultado sobre esta fecha");
                        }
                    }
                }
            }
        }
        else if ($this->validarSesion() && isset($_GET["page"]))
        {
            $page=filter_var($_GET["page"],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if ($page=="intereses" && isset($_POST["default"]))
            {  
                $tematicas = (isset($_POST["tematicas"]) && count($_POST["tematicas"]) && is_array($_POST["tematicas"])) ? $_POST["tematicas"] : [];
                if ($_SESSION["usuario"]->getUsuario()->guardarIntereses($tematicas));
                $this->jsonAndExit("success","",["redirect"=>"options.php"]);
            }
        }
            
    }
    public function getDirectorioDeTrabajo() : string {
        return $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']);
        
    }
   
    
    // private function renderAdminOptions() {
    //     echo $this->option("admin","Destinos","adm-link","options.php?mode=admin&page=destinos");
    //     echo $this->option("admin","Informes","adm-link","options.php?mode=admin&page=informes");
    //     echo $this->option("admin","Localidades","adm-link","options.php?mode=admin&page=localidades");
    //     echo $this->option("admin","Peticiones dadas de baja","adm-link","options.php?mode=admin&page=peticiones_bajadas");
    //     echo $this->option("admin","Peticiones nuevas","adm-link","options.php?mode=admin&page=peticiones_nuevas");
    //     echo $this->option("admin","Peticiones finalizadas","adm-link","options.php?mode=admin&page=peticiones_finalizadas");
    //     echo $this->option("admin","Reportes","adm-link","options.php?mode=admin&page=reportes");
    //     echo $this->option("admin","Tematicas","adm-link","options.php?mode=admin&page=tematicas");
    //     echo $this->option("admin","Usuarios","adm-link","options.php?mode=admin&page=usuarios");
    //     // echo $this->option("admin","Valoracion de usuarios","adm-link","options.php?mode=admin&page=valoraciones");

    // }
    public function loadAdminJS(){
        include_once "../app/admin.js.php";
    }
    public function loadModerJS(){
        include_once "../app/moder.js.php";
    }
    public function verificarDatosPDF($nroPeticion){
        $this->renderTemplate("cabeceraVerificarPDF.php");
        $peticion=Peticiones::getPeticionByNumero($nroPeticion);
        $peticion->mostrarPeticionFinalizadaVisitante();
        $this->renderTemplate("pieVerificarPDF.php");

    }
}
?>


