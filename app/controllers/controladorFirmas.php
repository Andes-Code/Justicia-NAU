<?php
if (__FILE__ == get_included_files()[0]) {
    require_once "../models/usuario.php";
    require_once "../models/firma.php";
    require_once "BDconection.php";
    require_once "controladorUsuarios.php";
    
}else{
    require_once "../app/models/usuario.php";
    require_once "../app/models/firma.php";
    require_once "../app/controllers/BDconection.php";
    require_once "../app/controllers/controladorUsuarios.php";
}
class Firmas{
    
    public static function getFirmasDePeticionByNumero(int $numero):array{
        try{
            $conexion = BDconection::conectar("user");
            $sql = "SELECT
                    correo
                    FROM firma
                    WHERE nroPet=:numero";
            $query=$conexion->prepare($sql);
            $query->execute([
                ":numero"=>$numero
            ]);
            if ($result=$query->fetchAll()){
                $firmas=[];
                foreach ($result as $firma){
                    array_push($firmas,$firma);
                }
                // print_r($firmas);
                return $firmas;
                // exit();
                // return new Peticion ($numero,$result['estado'],$result['objFirmas'],$result['fecha'],$result['titulo'],$result['cuerpo'],$destino,$usuario,$localidad,$tematicas,NULL);
            }else{
                // echo "no se encontro la localidad";
                return [];
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
    public static function firmaExiste(int $nroPet, string $usuario, string $tipoUsuario)
    {
        try{
            $conexion=BDconection::conectar("user");
            if ($tipoUsuario=="correo")
            {    
                $sql="SELECT
                    1
                    FROM firma
                    WHERE 
                    nroPet=:numero
                    AND
                    correo=:usuario
                    LIMIT 1";
            }else if ($tipoUsuario=="ip")
            {
                $sql="SELECT
                    1
                    FROM firma
                    WHERE 
                    nroPet=:numero
                    AND
                    ip=:usuario
                    LIMIT 1";
            }else{
                // no hay otro modo, se sale del programa
                exit();
            }
            $query=$conexion->prepare($sql);
            $query->execute([
                ":numero"=>$nroPet,
                ":usuario"=>$usuario 
            ]);
            if ($query->rowCount()==1)
                return TRUE;
            return FALSE;

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
    public static function quitarFirma(int $nroPet, string $usuario, string $tipoUsuario)
    {
        try{
            $conexion=BDconection::conectar("user");
            if ($tipoUsuario=="correo")
            {
                $sql="DELETE
                    FROM firma
                    WHERE 
                        nroPet = :numero
                        AND correo = :usuario
                        AND EXISTS (
                            SELECT 1 
                            FROM peticion 
                            WHERE nroPet = :numero0
                            AND estado = 0
                        );";
            }
            else if ($tipoUsuario=="ip")
            {
                $sql="DELETE
                    FROM firma
                    WHERE 
                    nroPet=:numero
                    AND
                    ip=:usuario
                    AND EXISTS (
                        SELECT 1 
                        FROM peticion 
                        WHERE nroPet = :numero0
                        AND estado = 0
                    );";
            }
            // $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query=$conexion->prepare($sql);
            $query->execute([
                ":numero"=>$nroPet,
                ":numero0"=>$nroPet,
                ":usuario"=>$usuario 
            ]);
            if ($query->rowCount()==1)
            {
                if ($tipoUsuario=="correo")
                    Usuarios::getUsuarioByCorreo($usuario)->sumarValoracion(-5);
                return TRUE;
            }
            return FALSE;

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
    public static function crearFirma(int $nroPet, string $usuario, string $tipoUsuario , string $comentario, int $anonimo)
    {
        try{
            $conexion=BDconection::conectar("user");
            if ($tipoUsuario=="correo"){
                $sql="INSERT INTO 
                        firma (nroPet, correo, comentario, anon)
                    SELECT 
                        :numero, :usuario, :comentario, :anon
                    FROM 
                        DUAL
                    WHERE 
                        EXISTS (
                            SELECT 1
                            FROM peticion
                            WHERE nroPet = :numero0
                            AND estado >= 0
                        );";
            }
            // uncomment below to add sign without login functionality
            // else if ($tipoUsuario=="ip")
            // {
            //     $sql="INSERT INTO 
            //             firma (nroPet, ip, comentario, anon)
            //         SELECT 
            //             :numero, :usuario, :comentario, :anon
            //         FROM 
            //             DUAL
            //         WHERE 
            //             EXISTS (
            //                 SELECT 1
            //                 FROM peticion
            //                 WHERE nroPet = :numero0
            //                 AND estado >= 0
            //             )";
                        
            // }
            else return false;
            $query=$conexion->prepare($sql);
            $query->execute([
                ":numero"=>$nroPet,
                ":numero0"=>$nroPet,
                ":usuario"=>$usuario, 
                ":comentario"=>$comentario,
                ":anon"=>$anonimo
            ]);
            if ($query->rowCount()==1)
            {
                if ($tipoUsuario=="correo")
                    Usuarios::getUsuarioByCorreo($usuario)->sumarValoracion(5);
                return TRUE;
            }
            return FALSE;

        }catch (PDOException $e) {
            // Log error message
            error_log('Database error: ' . $e->getMessage());
            // Show user-friendly message
            echo $e->getMessage();
            exit();
            echo 'Database error: Lo sentimos, ha ocurrido un problema. Por favor, inténtelo de nuevo más tarde.';
        } catch (Exception $e) {
            // Log error message
            error_log('General error: ' . $e->getMessage());
            // Show user-friendly message
            echo $e->getMessage();
            echo 'General error: Lo sentimos, ha ocurrido un problema. Por favor, inténtelo de nuevo más tarde.';
        }
    }
    public static function mostrarFirmas(int $nroPet, int $limite_inf=0):array{
        try{
            $conexion = BDconection::conectar("user");
            $sql = "SELECT
                    CASE 
                        WHEN anonimo=1 AND firmas.correo!='' THEN 'Usuario anonimo'
                        WHEN anonimo=0 AND firmas.correo!='' THEN nombreUsuario
                        WHEN firmas.correo='' AND ip!='0.0.0.0' THEN 'Usuario no registrado'
                    END AS usuario,
                    CASE 
                        WHEN ip!='0.0.0.0' OR anonimo=1 THEN 'default.png'
                        WHEN anonimo=0 THEN imagen
                    END AS imagen,
                    comentario,
                    fecha
                    FROM (
                        (SELECT 
                        correo,
                        ip,
                        anon as anonimo,
                        comentario,
                        fecha
                        FROM firma 
                        WHERE nroPet=:numero) as firmas
                        LEFT JOIN
                        (SELECT 
                        correo,
                        nombreUsuario,
                        imagen
                        FROM usuario) as usuarios
                        ON usuarios.correo=firmas.correo
                    ) 
                    LIMIT :inf,:sup";
            $query=$conexion->prepare($sql);
            $query->execute([
                ":numero"=>$nroPet,
                ":inf"=>$limite_inf,
                ":sup"=>5
            ]);
            if ($result=$query->fetchAll()){
                $firmas=[];
                foreach ($result as $firma){
                    array_push($firmas,Firma::mostrarFirmaDesdeArray($firma));
                }
                // print_r($firmas);
                return $firmas;
                // exit();
                // return new Peticion ($numero,$result['estado'],$result['objFirmas'],$result['fecha'],$result['titulo'],$result['cuerpo'],$destino,$usuario,$localidad,$tematicas,NULL);
            }else{
                // echo "no se encontro la localidad";
                return [];
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
    public static function ultimaFirma(int $nroPet):string {
        try{
            $conexion = BDconection::conectar("user");
            $sql = "SELECT
                    fecha
                    FROM firma
                    WHERE nroPet=:numero
                    ORDER BY idFirma DESC
                    LIMIT 1";
            $query=$conexion->prepare($sql);
            $query->execute([
                ":numero"=>$nroPet
            ]);
            if ($result=$query->fetch()){
                return $result["fecha"];
                // exit();
                // return new Peticion ($numero,$result['estado'],$result['objFirmas'],$result['fecha'],$result['titulo'],$result['cuerpo'],$destino,$usuario,$localidad,$tematicas,NULL);
            }else{
                // echo "no se encontro la localidad";
                return "0000-00-00";
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
    public static function comentariosPDF(int $nroPet){
        try{
            $conexion = BDconection::conectar("user");
            $sql = "SELECT
                    CASE 
                        WHEN anonimo=1 AND firmas.correo!='' THEN 'Usuario anonimo'
                        WHEN anonimo=0 AND firmas.correo!='' THEN nombreUsuario
                        WHEN firmas.correo='' AND ip!='0.0.0.0' THEN 'Usuario no registrado'
                    END AS usuario,
                    comentario,
                    fecha
                    FROM (
                        (SELECT 
                        correo,
                        ip,
                        anon as anonimo,
                        comentario,
                        fecha
                        FROM firma 
                        WHERE nroPet=:numero) as firmas
                        LEFT JOIN
                        (SELECT 
                        correo,
                        nombreUsuario
                        FROM usuario) as usuarios
                        ON usuarios.correo=firmas.correo
                    ) ORDER BY comentario != ''";
            $query=$conexion->prepare($sql);
            $query->execute([
                ":numero"=>$nroPet
            ]);
            if ($result=$query->fetchAll()){
                $firmas=[];
                foreach ($result as $firma){
                    if ($firma["comentario"]!='')
                    array_push($firmas,Firma::mostrarComentarioPDF($firma));
                }
                // print_r($firmas);
                return $firmas;
                // exit();
                // return new Peticion ($numero,$result['estado'],$result['objFirmas'],$result['fecha'],$result['titulo'],$result['cuerpo'],$destino,$usuario,$localidad,$tematicas,NULL);
            }else{
                // echo "no se encontro la localidad";
                return [];
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
    
}