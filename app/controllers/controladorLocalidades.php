<?php
if (__FILE__ == get_included_files()[0]) {
    require_once "BDconection.php";
    require_once "../models/provincia.php";
    require_once "../models/pais.php";
}else{
    require_once "../app/controllers/BDconection.php";
    require_once "../app/models/provincia.php";
    require_once "../app/models/pais.php";
}


class Localidades{

    public static function getLocalidadByPrimaryKey(?string $pais,?string $provincia,?string $localidad):?Localidad{
        try{
            if ($pais==NULL || $provincia==NULL || $localidad==NULL)
                return NULL;
            $conexion = BDconection::conectar("user");
            $sql = "SELECT 
            nombrePais,
            nombreProv,
            nombreLoc,
            estado
            FROM localidad 
            WHERE nombrePais=:pais 
            AND nombreProv=:prov 
            AND nombreLoc=:loc";
            $query=$conexion->prepare($sql);
            $query->execute([
                ":pais"=>$pais,
                ":prov"=>$provincia,
                ":loc"=>$localidad
            ]);
            if ($result=$query->fetch()){
                return new Localidad(new Provincia(new Pais($result["nombrePais"]),$result["nombreProv"]),$result["nombreLoc"],$result["estado"]);
            }else{
                // echo "no se encontro la localidad";
                return NULL;
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
    public static function localidadExiste(string $localidad):bool{
        $loc=explode(", ", $localidad);
        if(count($loc)==3){
            $pais=$loc[2];
            $prov=$loc[1];
            $loc=$loc[0];
        }else return FALSE;
        try{
            if (!$pais || !$prov || !$localidad)
                return FALSE;
            $conexion = BDconection::conectar("user");
            $sql = "SELECT nombrePais,nombreProv,nombreLoc
            FROM localidad 
            WHERE nombrePais=:pais 
            AND nombreProv=:prov 
            AND nombreLoc=:loc";
            $query=$conexion->prepare($sql);
            $query->execute([
                ":pais"=>$pais,
                ":prov"=>$prov,
                ":loc"=>$loc
            ]);
            if ($query->fetch()){
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
    public static function mostrarLocalidadesAdmin(string $estado){
        try{
            $estados=[
                "nuevas"=>0,
                "existentes"=>1
            ];
            $conexion = BDconection::conectar("user");
            $sql = "SELECT 
            nombrePais as pais,
            nombreProv as prov,
            nombreLoc as loc,
            estado
            FROM localidad
            WHERE estado=:estado";
            $query=$conexion->prepare($sql);
            $query->execute([
                ":estado"=>$estados[$estado]
            ]);
            if ($result=$query->fetchAll()){
                foreach ($result as $resultado){
                    $aux = new Pais($resultado["pais"]);
                    $aux = new Provincia($aux,$resultado["prov"]);
                    echo (new Localidad($aux,$resultado["loc"],$resultado["estado"]))->mostrarLocalidadAdmin();
                }
                if ($estado="nuevas")
                {
                    echo self::modalLocalidadesExistentes();
                }
            }
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
    public static function modalLocalidadesExistentes():string{
        try{
            $conexion = BDconection::conectar("user");
            $sql = "SELECT 
            nombrePais as pais,
            nombreProv as prov,
            nombreLoc as loc,
            estado
            FROM localidad 
            WHERE estado=1";
            $query=$conexion->prepare($sql);
            $query->execute();
            if ($result=$query->fetchAll()){
                $div="
                <div class='modal' id='visualizador-localidades-existentes'>
                    <div class='modal-background'></div>
                        <div class='modal-content flex flex-row flex-wrap justify-stretch' id='contenedor-firmas'>
                        
                    ";
                foreach ($result as $resultado){
                    $aux = new Pais($resultado["pais"]);
                    $aux = new Provincia($aux,$resultado["prov"]);
                    $div.= (new Localidad($aux,$resultado["loc"],$resultado["estado"]))->enlaceCombinarLocalidad() . " | ";
                }
                $div.="
                    </div>
                    <button class='modal-close is-large' id='visualizador-close' aria-label='close'></button>
                </div>";
                return $div;



            }else{
                // echo "no se encontro la peticion o las tematicas";
                return"";
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
    public static function combinarLocalidad(string $nuevo, string $existente):bool{
        $nuevo=explode(", ", $nuevo);
        if(count($nuevo)==3){
            $paisNuevo=$nuevo[2];
            $provNuevo=$nuevo[1];
            $locNuevo=$nuevo[0];
        }else return FALSE;
        $existente=explode(", ", $existente);
        if(count($existente)==3){
            $paisExistente=$existente[2];
            $provExistente=$existente[1];
            $locExistente=$existente[0];
        }else return FALSE;
        try{
            $conexion = BDconection::conectar("user");
            $sql = "UPDATE peticion
                    SET
                    nombrePais = :paisExistente
                    nombreProv = :provExistente
                    nombreLoc = :locExistente
                    WHERE 
                    nombrePais = :paisNuevo
                    nombreProv = :provNuevo
                    nombreLoc = :locNuevo
                    AND EXISTS (
                        SELECT 1 
                        FROM localidad 
                        WHERE 
                        nombrePais = :paisExistenteVerif
                        nombreProv = :provExistenteVerif
                        nombreLoc = :locExistenteVerif
                        AND estado = 1
                    )
                    AND EXISTS (
                        SELECT 1 
                        FROM destino 
                        WHERE n
                        nombrePais = :paisNuevoVerif
                        nombreProv = :provNuevoVerif
                        nombreLoc = :locNuevoVerif
                        AND estado = 0
                    )";
            $query=$conexion->prepare($sql);
            $query->execute([
                ":paisExistente"=>$paisExistente,
                ":provExistente"=>$provExistente,
                ":locExistente"=>$locExistente,
                ":paisNuevo"=>$paisNuevo,
                ":provNuevo"=>$provNuevo,
                ":locNuevo"=>$locNuevo,
                ":paisExistenteVerif"=>$paisExistente,
                ":provExistenteVerif"=>$provExistente,
                ":locExistenteVerif"=>$locExistente,
                ":paisNuevoVerif"=>$paisNuevo,
                ":provNuevoVerif"=>$provNuevo,
                ":locNuevoVerif"=>$locNuevo
            ]);
            $sql = "DELETE FROM localidad
                    WHERE
                    nombrePais = :paisNuevo
                    nombreProv = :provNuevo
                    nombreLoc = :locNuevo
                    AND estado=0";
            $query=$conexion->prepare($sql);
            $query->execute([
                ":paisNuevo"=>$nuevo["pais"],
                ":provNuevo"=>$nuevo["prov"],
                ":locNuevo"=>$nuevo["loc"]
            ]);
            if ($query->rowCount()==1){
                return TRUE;
            }else{
                // echo "no se encontro la peticion o las tematicas";
                return FALSE;
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
    public static function admitirLocalidad(string $nuevo):bool{
        $nuevo=explode(", ", $nuevo);
        if(count($nuevo)==3){
            $paisNuevo=$nuevo[2];
            $provNuevo=$nuevo[1];
            $locNuevo=$nuevo[0];
        }else return FALSE;
        try{
            $conexion = BDconection::conectar("user");
            $sql = "UPDATE localidad
                    SET estado=1
                    WHERE 
                    nombrePais = :paisNuevo
                    AND nombreProv = :provNuevo
                    AND nombreLoc = :locNuevo
                    AND estado=0";
            $query=$conexion->prepare($sql);
            $query->execute([
                ":paisNuevo"=>$paisNuevo,
                ":provNuevo"=>$provNuevo,
                ":locNuevo"=>$locNuevo
            ]);
            if ($query->rowCount()==1){
                return TRUE;
            }else{
                return FALSE;
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
    public static function eliminarLocalidad(string $nuevo):bool{
        $nuevo=explode(", ", $nuevo);
        if(count($nuevo)==3){
            $paisNuevo=$nuevo[2];
            $provNuevo=$nuevo[1];
            $locNuevo=$nuevo[0];
        }else return FALSE;
        try{
            $conexion = BDconection::conectar("user");
            $sql = "DELETE FROM localidad
                    WHERE 
                    nombrePais = :paisNuevo AND
                    nombreProv = :provNuevo AND
                    nombreLoc = :locNuevo AND
                    estado=0";
            $query=$conexion->prepare($sql);
            $query->execute([
                ":paisNuevo"=>$paisNuevo,
                ":provNuevo"=>$provNuevo,
                ":locNuevo"=>$locNuevo
            ]);
            if ($query->rowCount()==1){
                return TRUE;
            }else{
                return FALSE;
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
        return FALSE;
    }
    public static function crearLocalidad(string $localidad):bool{
        $nuevo=explode(", ", $localidad);
        if(count($nuevo)==3){
            $paisNuevo=$nuevo[2];
            $provNuevo=$nuevo[1];
            $locNuevo=$nuevo[0];
        }else return FALSE;
        try{
            $conexion = BDconection::conectar("user");
            $sql = "INSERT INTO localidad 
            (nombrePais,
            nombreProv,
            nombreLoc,
            estado)
            VALUES (:paisNuevo,:provNuevo,:locNuevo,0)";
            $query=$conexion->prepare($sql);
            $query->execute([
                ":paisNuevo"=>$paisNuevo,
                ":provNuevo"=>$provNuevo,
                ":locNuevo"=>$locNuevo
            ]);
            if ($query->rowCount()==1){
                return TRUE;
            }else{
                return FALSE;
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
        return FALSE;
    }
}