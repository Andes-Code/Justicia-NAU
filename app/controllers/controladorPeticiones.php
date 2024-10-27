<?php
if (__FILE__ == get_included_files()[0]) {
    require_once "../models/usuario.php";
    require_once "../models/afiliado.php";
    require_once "BDconection.php";
    require_once "controladorDestinos.php";
    require_once "controladorUsuarios.php";
    require_once "controladorLocalidades.php";
    require_once "controladorTematicas.php";
    require_once "controladorFirmas.php";
    require_once "controladorImagenes.php";
    require_once "controladorPaises.php";
    require_once "controladorProvincias.php";
    
}else{
    require_once "../app/models/usuario.php";
    require_once "../app/models/afiliado.php";
    require_once "../app/controllers/BDconection.php";
    require_once "../app/controllers/controladorDestinos.php";
    require_once "../app/controllers/controladorUsuarios.php";
    require_once "../app/controllers/controladorLocalidades.php";
    require_once "../app/controllers/controladorTematicas.php";
    require_once "../app/controllers/controladorFirmas.php";
    require_once "../app/controllers/controladorImagenes.php";
    require_once "../app/controllers/controladorPaises.php";
    require_once "../app/controllers/controladorProvincias.php";
}
class Peticiones{
    private array $estados=[
        "verificadas"=>1,
        "sin verificar"=>0,
        "sin completar"=>-1
    ];
    public static function mostrarPeticiones(string $usuario, string $tipoUsuario, int $limite_inf=0,){
        try {
            // Código de conexión y consulta
            $conexion = BDconection::conectar("user");
            if ($tipoUsuario=="ip")
            {
                // print_r(json_encode([
                //     "status"=>"error",
                //     "message"=>"you cannot interact without session",
                //     "redirect"=>"login.php"
                // ]));
                // exit();
                $sql="SELECT 
                        nroPet
                        FROM peticion
                        WHERE
                        estado=0
                        ORDER BY nroPet DESC
                        LIMIT :inf , 10";
                $query=$conexion->prepare($sql);
                $query->execute([
                    // ":estado"=>$estados[$estado],
                    ":inf"=>$limite_inf
                ]);
            }
            else if ($tipoUsuario=="correo")
            {
                $sql="SELECT DISTINCT p.nroPet
                    FROM peticion p
                    LEFT JOIN trata pt ON p.nroPet = pt.nroPet
                    LEFT JOIN interesa ui ON pt.nombreTem = ui.nombreTem AND ui.correo = :correo
                    WHERE p.estado = 0
                    ORDER BY ui.nombreTem IS NULL, p.nroPet DESC
                    LIMIT :inf, 10";
                $query=$conexion->prepare($sql);
                $query->execute([
                    ":correo"=>$usuario,
                    ":inf"=>$limite_inf
                ]);
            }
            $result=$query->fetchAll();
            if ($result)
            {
                $arreglo=[];
                if ($tipoUsuario=="correo")
                {
                    foreach ($result as $pet)
                    {
                        $peticion = Peticiones::getPeticionByNumero($pet["nroPet"]);
                        // yata
                        $arreglo[].= $peticion->mostrarPeticion(Firmas::firmaExiste($pet["nroPet"],$usuario,"correo"),$usuario);
                    }
                }
                else if ($tipoUsuario=="ip")
                {
                    foreach ($result as $pet)
                    {
                        $peticion = Peticiones::getPeticionByNumero($pet["nroPet"]);
                        $arreglo[].= $peticion->mostrarPeticion(FALSE,"");
                    }
                }
                if ($limite_inf==0)
                    $arreglo[].=self::loadMorePetitionsButton();
                return $arreglo;
            }
        } catch (PDOException $e) {
            // Log error message
            error_log('Database error: ' . $e->getMessage());
            // Show user-friendly message
            echo $e->getMessage();
            echo 'Lo sentimos, ha ocurrido un problema. Por favor, inténtelo de nuevo más tarde.';
        } catch (Exception $e) {
            // Log error message
            error_log('General error: ' . $e->getMessage());
            // Show user-friendly message
            echo $e->getMessage();
            echo 'Lo sentimos, ha ocurrido un problema. Por favor, inténtelo de nuevo más tarde.';
        }
    }
    public static function peticionExiste(int $nroPet):bool{
        try {
            $conexion = BDconection::conectar("user");
            $sql="SELECT 
                    nroPet
                    FROM peticion
                    WHERE
                    nroPet=:nro";
            $query=$conexion->prepare($sql);
            $query->execute([
                ":nro"=>$nroPet
            ]);
            $result=$query->fetch();
            if ($result){
                return TRUE;
            }
            return FALSE;
        } catch (PDOException $e) {
            // Log error message
            error_log('Database error: ' . $e->getMessage());
            // Show user-friendly message
            echo $e->getMessage();
            echo 'Lo sentimos, ha ocurrido un problema. Por favor, inténtelo de nuevo más tarde.';
        } catch (Exception $e) {
            // Log error message
            error_log('General error: ' . $e->getMessage());
            // Show user-friendly message
            echo $e->getMessage();
            echo 'Lo sentimos, ha ocurrido un problema. Por favor, inténtelo de nuevo más tarde.';
        }
    }
    public static function crearPeticion(string $titulo, string $cuerpo, string $destino, string $localidad/*, int $objetivo*/){
        try{
            if (/*intval($objetivo)<=0 || */strlen($cuerpo)<=20 || strlen($titulo)<=10)
            {
                return 0;
            }
            $titulo=filter_var($titulo,FILTER_SANITIZE_SPECIAL_CHARS);
            $cuerpo=filter_var($cuerpo,FILTER_SANITIZE_SPECIAL_CHARS);
            $loc=explode(", ", $localidad);
            if(count($loc)==3){
                $pais=$loc[2];
                $prov=$loc[1];
                $loc=$loc[0];
            }
            $sql = "INSERT INTO peticion
                    (estado,
                    titulo,
                    cuerpo,
                    correo,
                    objFirmas)
                    VALUES
                    (-1,
                    :titulo,
                    :cuerpo,
                    :correo,
                    :objetivo)";
            $conexion = BDconection::conectar("user");
            # probar hacer todo en una consulta
            $query=$conexion->prepare($sql);
            $result=$query->execute([
                ":titulo"=>$titulo,
                ":cuerpo"=>$cuerpo,
                ":objetivo"=>5,
                ":correo"=>$_SESSION["usuario"]->getUsuario()->getCorreo()
            ]);
            if ($result){
                $nroPet=$conexion->lastInsertId();
                if (!Destinos::destinoExiste($destino) && !preg_match('/^\s*$/',$destino))
                {
                    if (Destinos::crearDestino($destino,""))
                    {
                        $sql="UPDATE peticion SET nombreDest=:destino WHERE nroPet=:numero";
                        $query=$conexion->prepare($sql);
                        $result=$query->execute([
                            ":destino"=>$destino,
                            ":numero"=>$nroPet
                        ]);
                    }
                }
                if (Localidades::localidadExiste($localidad)) {
                    $sql="UPDATE peticion set nombrePais=:pais, nombreProv=:prov, nombreLoc=:loc WHERE nroPet=:numero";
                    $query=$conexion->prepare($sql);
                    $result=$query->execute([
                        ":pais"=>$pais,
                        ":prov"=>$prov,
                        ":loc"=>$loc,
                        ":numero"=>$nroPet
                    ]);
                }
                // echo $sql;
                // exit();
                return $nroPet;
                // exit();
                // return new Peticion ($numero,$result['estado'],$result['objFirmas'],$result['fecha'],$result['titulo'],$result['cuerpo'],$usuario,$tematicas,$firmas,$imagenes,$destino,$localidad);
            }else{
                echo "hubo un error al crear la peticion";
                return 0;
                // app::renderUsuarioNoEncontrado($correo)
            }

        }catch (PDOException $e) {
            // Log error message
            error_log('Database error: ' . $e->getMessage());
            // Show user-friendly message
            echo $e->getMessage();
            echo 'Lo sentimos, ha ocurrido un problema. Por favor, inténtelo de nuevo más tarde.';
        } catch (Exception $e) {
            // Log error message
            error_log('General error: ' . $e->getMessage());
            // Show user-friendly message
            echo $e->getMessage();
            echo 'Lo sentimos, ha ocurrido un problema. Por favor, inténtelo de nuevo más tarde.';
        }
    }
    public static function agregarTematicas(int $nroPet,array $tematicas){
        if (count($tematicas)==0)
            return;
        try{  
            $conexion = BDconection::conectar("user");
            # probar hacer todo en una consulta
            $sql = "INSERT INTO trata
                    (nroPet,
                    nombreTem)
                    VALUES
                    (:nroPet,
                    :tematica)";
            $query=$conexion->prepare($sql);
            foreach ($tematicas as $tematica){
                if (!Tematicas::tematicaExiste($tematica) && !preg_match('/^\s*$/',$tematica))
                {
                    if (Tematicas::crearTematica($tematica,""))
                    {
                        $query->execute([
                            ":nroPet"=>$nroPet,
                            ":tematica"=>$tematica
                        ]);
                    }
                }
            }
        }catch (PDOException $e) {
            // Log error message
            error_log('Database error: ' . $e->getMessage());
            // Show user-friendly message
            echo $e->getMessage();
            echo 'Lo sentimos, ha ocurrido un problema. Por favor, inténtelo de nuevo más tarde.';
        } catch (Exception $e) {
            // Log error message
            error_log('General error: ' . $e->getMessage());
            // Show user-friendly message
            echo $e->getMessage();
            echo 'Lo sentimos, ha ocurrido un problema. Por favor, inténtelo de nuevo más tarde.';
        }
    }
    public static function getPeticionByNumero(int $numero){
        try{
            $conexion = BDconection::conectar("user");
            # probar hacer todo en una consulta
            $sql = "SELECT
                    estado,
                    objFirmas,
                    titulo,
                    cuerpo,
                    fecha,
                    correo,
                    nombreDest,
                    nombrePais,nombreProv,nombreLoc,
                    nroPet_multiple
                    FROM peticion
                    WHERE nroPet=:numero";
            $query=$conexion->prepare($sql);
            $query->execute([
                ":numero"=>$numero
            ]);
            if ($result=$query->fetch()){
                $localidad = Localidades::getLocalidadByPrimaryKey($result['nombrePais'],$result['nombreProv'],$result['nombreLoc']);
                $destino = Destinos::getDestinoByNombre($result['nombreDest']);
                $usuario = Usuarios::getUsuarioByCorreo($result['correo']);
                $tematicas = Tematicas::getTematicasDePeticionByNumero($numero);
                $firmas = Firmas::getFirmasDePeticionByNumero($numero);
                $imagenes = Imagenes::getImagenesByNumeroPeticion($numero);
                // exit();
                return new Peticion ($numero,$result['estado'],$result['objFirmas'],$result['fecha'],$result['titulo'],$result['cuerpo'],$usuario,$tematicas,$firmas,$imagenes,$destino,$localidad);
            }else{
                echo "No se encontró la peticion";
                // app::renderUsuarioNoEncontrado($correo)
            }

        }catch (PDOException $e) {
            // Log error message
            error_log('Database error: ' . $e->getMessage());
            // Show user-friendly message
            echo $e->getMessage();
            echo 'Lo sentimos, ha ocurrido un problema. Por favor, inténtelo de nuevo más tarde.';
        } catch (Exception $e) {
            // Log error message
            error_log('General error: ' . $e->getMessage());
            // Show user-friendly message
            echo $e->getMessage();
            echo 'Lo sentimos, ha ocurrido un problema. Por favor, inténtelo de nuevo más tarde.';
        }
    }
    public static function evaluarObjetivo(int $nroPet){
        $peticion=self::getPeticionByNumero($nroPet);
        if ($peticion->evaluarObjetivo()==$peticion->getObjetivo())
            return;
        try{
            $conexion = BDconection::conectar("user");
            $sql = "UPDATE peticion
                    SET objFirmas=:objetivo
                    WHERE nroPet=:numero";
            $query=$conexion->prepare($sql);
            $query->execute([
                ":numero"=>$nroPet,
                ":objetivo"=>$peticion->getObjetivo()
            ]);
            return;

        }catch (PDOException $e) {
            // Log error message
            error_log('Database error: ' . $e->getMessage());
            // Show user-friendly message
            echo $e->getMessage();
            echo 'Lo sentimos, ha ocurrido un problema. Por favor, inténtelo de nuevo más tarde.';
        } catch (Exception $e) {
            // Log error message
            error_log('General error: ' . $e->getMessage());
            // Show user-friendly message
            echo $e->getMessage();
            echo 'Lo sentimos, ha ocurrido un problema. Por favor, inténtelo de nuevo más tarde.';
        }
    }
    public static function buscarPeticiones(string $value,int $limite_inf=0):array{
        try{
            $conexion = BDconection::conectar("user");
            $busqueda = filter_var($value,FILTER_SANITIZE_SPECIAL_CHARS);
            $nro = intval($value);
            # probar hacer todo en una consulta
            $sql = "SELECT
                    nroPet as numero
                    FROM (peticion NATURAL JOIN usuario) NATURAL JOIN (
                        SELECT nroPet FROM peticion
                        WHERE nroPet=:numero
                        UNION
                        SELECT nroPet FROM peticion
                        WHERE titulo LIKE CONCAT(:titulo,'%')
                        UNION
                        SELECT nroPet FROM peticion
                        WHERE cuerpo LIKE CONCAT(:cuerpo,'%')
                        UNION
                        SELECT nroPet FROM peticion
                        WHERE nombreDest LIKE CONCAT(:destino,'%')
                        UNION
                        SELECT nroPet FROM peticion
                        WHERE nombrePais LIKE CONCAT(:pais,'%')
                        UNION
                        SELECT nroPet FROM peticion
                        WHERE nombreProv LIKE CONCAT(:prov,'%')
                        UNION
                        SELECT nroPet FROM peticion
                        WHERE nombreLoc LIKE CONCAT(:loc,'%')
                        UNION
                        SELECT nroPet FROM trata
                        WHERE nombreTem LIKE CONCAT(:tem,'%')
                        UNION
                        SELECT nroPet FROM peticion JOIN (
                            SELECT correo FROM usuario
                            WHERE nombreUsuario LIKE CONCAT(:nombre,'%')) as usuarios
                        ON peticion.correo=usuarios.correo
                    ) as peticiones
                    WHERE estado>=0
                    LIMIT :inf,:sup";
                    // agregar que estado >= 0
            $query=$conexion->prepare($sql);
            $query->execute([
                ":numero"=>$nro,
                ":titulo"=>$busqueda,
                ":cuerpo"=>$busqueda,
                ":destino"=>$busqueda,
                ":pais"=>$busqueda,
                ":prov"=>$busqueda,
                ":loc"=>$busqueda,
                ":tem"=>$busqueda,
                ":nombre"=>$busqueda,
                ":inf"=>$limite_inf,
                ":sup"=>8
            ]);
            if ($result=$query->fetchAll()){
                $peticiones=[];
                foreach ($result as $arr){
                    // echo $peticion-> mostrarEnlace();
                    array_push($peticiones,(self::getPeticionByNumero($arr["numero"]))->mostrarEnlace());
                }
                return $peticiones;

                // return new Peticion ($numero,$result['estado'],$result['objFirmas'],$result['fecha'],$result['titulo'],$result['cuerpo'],$usuario,$tematicas,$firmas,$imagenes,$destino,$localidad);
            }else{
                return [];
                // echo "No se encontró la peticion";
                // app::renderUsuarioNoEncontrado($correo)
            }

        }catch (PDOException $e) {
            // Log error message
            error_log('Database error: ' . $e->getMessage());
            // Show user-friendly message
            echo $e->getMessage();
            echo 'Lo sentimos, ha ocurrido un problema. Por favor, inténtelo de nuevo más tarde.';
        } catch (Exception $e) {
            // Log error message
            error_log('General error: ' . $e->getMessage());
            // Show user-friendly message
            echo $e->getMessage();
            echo 'Lo sentimos, ha ocurrido un problema. Por favor, inténtelo de nuevo más tarde.';
        }
    }
    private static function actualizarEstado(int $nroPet, int $estado):void{
        try {
            // Código de conexión y consulta
            $conexion = BDconection::conectar("user");
            $sql="UPDATE peticion
                    SET estado=:estado
                    WHERE nroPet=:numero";
            $query=$conexion->prepare($sql);
            $query->execute([
                ":numero"=>$nroPet,
                ":estado"=>$estado
            ]);
            return;
            // if ($query->rowCount()==1)
            // {
            //     return TRUE;   
            // }
            // return FALSE;   
        } catch (PDOException $e) {
            // Log error message
            error_log('Database error: ' . $e->getMessage());
            // Show user-friendly message
            echo $e->getMessage();
            echo 'Lo sentimos, ha ocurrido un problema. Por favor, inténtelo de nuevo más tarde.';
        } catch (Exception $e) {
            // Log error message
            error_log('General error: ' . $e->getMessage());
            // Show user-friendly message
            echo $e->getMessage();
            echo 'Lo sentimos, ha ocurrido un problema. Por favor, inténtelo de nuevo más tarde.';
        }
    }
    public static function verificarEstado(int $nroPet):void{
        try {
            // Código de conexión y consulta
            $conexion = BDconection::conectar("user");
            $sql="SELECT estado,objetivo,firmas
                    FROM peticion_objetivo
                    WHERE numero=:numero";
            $query=$conexion->prepare($sql);
            $query->execute([
                ":numero"=>$nroPet  
            ]);
            $result=$query->fetch();
            if ($result)
                if ($result["estado"]==0 && $result["objetivo"]<=$result["firmas"])
                    self::actualizarEstado($nroPet,1);
        } catch (PDOException $e) {
            // Log error message
            error_log('Database error: ' . $e->getMessage());
            // Show user-friendly message
            echo $e->getMessage();
            echo 'Lo sentimos, ha ocurrido un problema. Por favor, inténtelo de nuevo más tarde.';
        } catch (Exception $e) {
            // Log error message
            error_log('General error: ' . $e->getMessage());
            // Show user-friendly message
            echo $e->getMessage();
            echo 'Lo sentimos, ha ocurrido un problema. Por favor, inténtelo de nuevo más tarde.';
        }
    }
    public static function mostrarPeticionesNuevas(){
        try {
            // Código de conexión y consulta
            $conexion = BDconection::conectar("user");
            $sql="SELECT 
                    nroPet
                    FROM peticion
                    WHERE 
                    estado=-1
                    ORDER BY fecha DESC";
            $query=$conexion->prepare($sql);
            $query->execute();
            $result=$query->fetchAll();
            if ($result){
                $arr=[];
                foreach ($result as $pet)
                {
                    (self::getPeticionByNumero($pet["nroPet"]))->mostrarPeticionNueva();
                }
            }
        } catch (PDOException $e) {
            // Log error message
            error_log('Database error: ' . $e->getMessage());
            // Show user-friendly message
            echo $e->getMessage();
            echo 'Lo sentimos, ha ocurrido un problema. Por favor, inténtelo de nuevo más tarde.';
        } catch (Exception $e) {
            // Log error message
            error_log('General error: ' . $e->getMessage());
            // Show user-friendly message
            echo $e->getMessage();
            echo 'Lo sentimos, ha ocurrido un problema. Por favor, inténtelo de nuevo más tarde.';
        }
    }
    public static function mostrarPeticionesFinalizadas(){
        try {
            // Código de conexión y consulta
            $conexion = BDconection::conectar("user");
            $sql="SELECT 
                    numero
                    FROM peticion_objetivo
                    WHERE 
                    estado=0
                    AND objetivo<=firmas
                    ORDER BY numero DESC";
            $query=$conexion->prepare($sql);
            $query->execute();
            $result=$query->fetchAll();
            if ($result){
                $arr=[];
                foreach ($result as $pet)
                {
                    (self::getPeticionByNumero($pet["numero"]))->mostrarPeticionFinalizadaAdmin();
                }
            }
        } catch (PDOException $e) {
            // Log error message
            error_log('Database error: ' . $e->getMessage());
            // Show user-friendly message
            echo $e->getMessage();
            echo 'Lo sentimos, ha ocurrido un problema. Por favor, inténtelo de nuevo más tarde.';
        } catch (Exception $e) {
            // Log error message
            error_log('General error: ' . $e->getMessage());
            // Show user-friendly message
            echo $e->getMessage();
            echo 'Lo sentimos, ha ocurrido un problema. Por favor, inténtelo de nuevo más tarde.';
        }
    }
    public static function numerosDePeicionestNuevas():array{
        try {
            // Código de conexión y consulta
            $conexion = BDconection::conectar("user");
            $sql="SELECT 
                    nroPet
                    FROM peticion
                    WHERE 
                    estado=-1
                    ORDER BY fecha DESC";
            $query=$conexion->prepare($sql);
            $query->execute();
            $result=$query->fetchAll();
            if ($result){
                $arr=[];
                foreach ($result as $pet)
                {
                    array_push($arr,$pet["nroPet"]);
                }
                return $arr;
            }
            return [];
        } catch (PDOException $e) {
            // Log error message
            error_log('Database error: ' . $e->getMessage());
            // Show user-friendly message
            echo $e->getMessage();
            echo 'Lo sentimos, ha ocurrido un problema. Por favor, inténtelo de nuevo más tarde.';
        } catch (Exception $e) {
            // Log error message
            error_log('General error: ' . $e->getMessage());
            // Show user-friendly message
            echo $e->getMessage();
            echo 'Lo sentimos, ha ocurrido un problema. Por favor, inténtelo de nuevo más tarde.';
        }
    }
    
    public static function loadMorePetitionsButton(){
        $div="
        <div class='is-centered'>
            <button class='button is-rounded load-more-pet' id='load-more'>+</button>
        </div>";
        return $div;
    }
    public static function getArregloDePeticion(int $numero){
        try {
            // Código de conexión y consulta
            $conexion = BDconection::conectar("user");
            $sql="SELECT 
                    estado,
                    objFirmas,
                    titulo,
                    cuerpo,
                    fecha,
                    correo,
                    nombreDest,
                    nombrePais,nombreProv,nombreLoc,
                    nroPet_multiple
                    FROM peticion
                    WHERE 
                    nroPet=:numero";
            $query=$conexion->prepare($sql);
            $query->execute([
                ":numero"=>$numero
            ]);
            $result=$query->fetch();
            if ($result){
                $result["tematicas"]=Tematicas::getTematicasDePeticionByNumero($numero);
                return $result;
            }
            return [];
        } catch (PDOException $e) {
            // Log error message
            error_log('Database error: ' . $e->getMessage());
            // Show user-friendly message
            echo $e->getMessage();
            echo 'Lo sentimos, ha ocurrido un problema. Por favor, inténtelo de nuevo más tarde.';
        } catch (Exception $e) {
            // Log error message
            error_log('General error: ' . $e->getMessage());
            // Show user-friendly message
            echo $e->getMessage();
            echo 'Lo sentimos, ha ocurrido un problema. Por favor, inténtelo de nuevo más tarde.';
        }
    }
    public static function alta(int $numero):bool{
        try {
            if (self::peticionExiste($numero))
            {
                $conexion = BDconection::conectar("user");
                $sql="UPDATE 
                        peticion 
                        SET 
                        estado=0 
                        WHERE 
                        nroPet=:numero AND
                        estado=-1";
                $query=$conexion->prepare($sql);
                $query->execute([
                    ":numero"=>$numero
                ]);
                if ($query->rowCount()==1)
                {
                    $sql="SELECT
                            correo
                            FROM 
                            peticion
                            WHERE 
                            nroPet=:numero";
                    $query=$conexion->prepare($sql);
                    $query->execute([
                        ":numero"=>$numero
                    ]);
                    Usuarios::getUsuarioByCorreo($query->fetchColumn())->sumarValoracion(30);
                    return TRUE;
                }return FALSE;
            }
        } catch (PDOException $e) {
            // Log error message
            error_log('Database error: ' . $e->getMessage());
            // Show user-friendly message
            echo $e->getMessage();
            echo 'Lo sentimos, ha ocurrido un problema. Por favor, inténtelo de nuevo más tarde.';
        } catch (Exception $e) {
            // Log error message
            error_log('General error: ' . $e->getMessage());
            // Show user-friendly message
            echo $e->getMessage();
            echo 'Lo sentimos, ha ocurrido un problema. Por favor, inténtelo de nuevo más tarde.';
        }
    }
    public static function baja(int $numero):bool{
        try {
            if (self::peticionExiste($numero))
            {
                $conexion = BDconection::conectar("user");
                $sql="UPDATE 
                        peticion 
                        SET 
                        estado=-2 
                        WHERE 
                        nroPet=:numero AND
                        estado=-1";
                $query=$conexion->prepare($sql);
                $query->execute([
                    ":numero"=>$numero
                ]);
                if ($query->rowCount()==1)
                {
                    $sql="SELECT
                            correo
                            FROM 
                            peticion
                            WHERE 
                            nroPet=:numero";
                    $query=$conexion->prepare($sql);
                    $query->execute([
                        ":numero"=>$numero
                    ]);
                    Usuarios::getUsuarioByCorreo($query->fetchColumn())->sancionar(30);
                    return TRUE;
                }return FALSE;
            }
        } catch (PDOException $e) {
            // Log error message
            error_log('Database error: ' . $e->getMessage());
            // Show user-friendly message
            echo $e->getMessage();
            echo 'Lo sentimos, ha ocurrido un problema. Por favor, inténtelo de nuevo más tarde.';
        } catch (Exception $e) {
            // Log error message
            error_log('General error: ' . $e->getMessage());
            // Show user-friendly message
            echo $e->getMessage();
            echo 'Lo sentimos, ha ocurrido un problema. Por favor, inténtelo de nuevo más tarde.';
        }
    }
    public static function admitirPDF(int $numero):bool{
        try {
            if (self::peticionExiste($numero))
            {
                $conexion = BDconection::conectar("user");
                $sql="UPDATE 
                        peticion 
                        SET 
                        estado=1
                        WHERE 
                        nroPet=:numero AND
                        estado=0";
                $query=$conexion->prepare($sql);
                $query->execute([
                    ":numero"=>$numero
                ]);
                if ($query->rowCount()==1)
                {
                    $sql="SELECT
                            correo
                            FROM 
                            peticion
                            WHERE 
                            nroPet=:numero";
                    $query=$conexion->prepare($sql);
                    $query->execute([
                        ":numero"=>$numero
                    ]);
                    Usuarios::getUsuarioByCorreo($query->fetchColumn())->sumarValoracion(50);
                    return TRUE;
                }return FALSE;
            }
        } catch (PDOException $e) {
            // Log error message
            error_log('Database error: ' . $e->getMessage());
            // Show user-friendly message
            echo $e->getMessage();
            echo 'Lo sentimos, ha ocurrido un problema. Por favor, inténtelo de nuevo más tarde.';
        } catch (Exception $e) {
            // Log error message
            error_log('General error: ' . $e->getMessage());
            // Show user-friendly message
            echo $e->getMessage();
            echo 'Lo sentimos, ha ocurrido un problema. Por favor, inténtelo de nuevo más tarde.';
        }
    }
    public static function perteneceA(int $nroPet, string $correo):bool{
        try {
            $conexion = BDconection::conectar("user");
            $sql="SELECT 
                    1
                    FROM 
                    peticion 
                    WHERE 
                    nroPet=:nroPet AND
                    correo=:correo AND
                    estado=0 -- o 1 si hay vista exclusiva
                    ";
            $query=$conexion->prepare($sql);
            $query->execute([
                ":nroPet"=>$nroPet,
                ":correo"=>$correo
            ]);
            if ($query->rowCount()==1)
                return TRUE;
            return FALSE;
        } catch (PDOException $e) {
            // Log error message
            error_log('Database error: ' . $e->getMessage());
            // Show user-friendly message
            echo $e->getMessage();
            echo 'Lo sentimos, ha ocurrido un problema. Por favor, inténtelo de nuevo más tarde.';
        } catch (Exception $e) {
            // Log error message
            error_log('General error: ' . $e->getMessage());
            // Show user-friendly message
            echo $e->getMessage();
            echo 'Lo sentimos, ha ocurrido un problema. Por favor, inténtelo de nuevo más tarde.';
        }
    }
    public static function finalizar(int $nroPet):bool{
        try {
            $conexion = BDconection::conectar("user");
            $sql="UPDATE 
                    peticion 
                    SET estado=1 -- o 2 si hay vista exclusiva
                    WHERE 
                    nroPet=:nroPet AND 
                    estado=0 -- o 1 si hay vista exclusiva
                    ";
            $query=$conexion->prepare($sql);
            $query->execute([
                ":nroPet"=>$nroPet
            ]);
            if ($query->rowCount()==1)
                return TRUE;
            return FALSE;
        } catch (PDOException $e) {
            // Log error message
            error_log('Database error: ' . $e->getMessage());
            // Show user-friendly message
            echo $e->getMessage();
            echo 'Lo sentimos, ha ocurrido un problema. Por favor, inténtelo de nuevo más tarde.';
        } catch (Exception $e) {
            // Log error message
            error_log('General error: ' . $e->getMessage());
            // Show user-friendly message
            echo $e->getMessage();
            echo 'Lo sentimos, ha ocurrido un problema. Por favor, inténtelo de nuevo más tarde.';
        }
    }
}

