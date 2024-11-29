<?php
if (__FILE__ == get_included_files()[0]) {
    require_once "BDconection.php";
    
}else{
    require_once "../app/controllers/BDconection.php";
}


class Destinos{

    public static function getDestinoByNombre(?string $nombre):?Destino{
        try{
            if ($nombre==NULL)
                return NULL;
            $conexion = BDconection::conectar("user");
            $sql = "SELECT 
            nombreDest,
            descr,
            estado
            FROM destino 
            WHERE nombreDest=:nombre";
            $query=$conexion->prepare($sql);
            $query->execute([
                ":nombre"=>$nombre
            ]);
            if ($result=$query->fetch()){
                return new Destino($result["nombreDest"],$result["descr"],$result["estado"]);
            }else{
                // echo "no se encontro El destino";
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
    public static function mostrarDestinosAdmin(string $estado){
        try{
            $estados=[
                "nuevos"=>0,
                "existentes"=>1
            ];
            $conexion = BDconection::conectar("user");
            $sql = "SELECT 
            nombreDest as nombre,
            descr,
            estado
            FROM destino
            WHERE estado=:estado";
            $query=$conexion->prepare($sql);
            $query->execute([
                ":estado"=>$estados[$estado]
            ]);
            if ($result=$query->fetchAll()){
                foreach ($result as $resultado){
                    echo (new Destino($resultado["nombre"],$resultado["descr"],$resultado["estado"]))->mostrarDestinoAdmin();
                }
                if ($estado="nuevos")
                {
                    echo self::modalDestinosExistentes();
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
    public static function destinoExiste(string $nombre):bool{
        try{
            if ($nombre==NULL)
                return FALSE;
            $conexion = BDconection::conectar("user");
            $sql = "SELECT 
            nombreDest
            FROM destino 
            WHERE nombreDest=:nombre";
            $query=$conexion->prepare($sql);
            $query->execute([
                ":nombre"=>$nombre
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
    public static function modalDestinosExistentes():string{
        try{
            $conexion = BDconection::conectar("user");
            $sql = "SELECT 
            nombreDest,
            descr,
            estado
            FROM destino 
            WHERE estado=1";
            $query=$conexion->prepare($sql);
            $query->execute();
            if ($result=$query->fetchAll()){
                $div="
                <div class='modal' id='visualizador-destinos-existentes'>
                    <div class='modal-background'></div>
                        <div class='modal-content flex flex-row flex-wrap justify-stretch' id='contenedor-firmas'>
                        
                    ";
                foreach ($result as $resultado){
                    $div.= (new Destino ($resultado["nombreDest"],$resultado["descr"],$resultado["estado"]))->enlaceCombinarDestino() . " | ";
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
    public static function combinarDestino(string $nuevo, string $existente):bool{
        try{
            $conexion = BDconection::conectar("user");
            $sql = "UPDATE peticion
                    SET nombreDest = :existente
                    WHERE nombreDest = :nuevo
                    AND EXISTS (
                        SELECT 1 
                        FROM destino 
                        WHERE nombreDest = :existenteVerif
                        AND estado = 1
                    )
                    AND EXISTS (
                        SELECT 1 
                        FROM destino 
                        WHERE nombreDest = :nuevoVerif
                        AND estado = 0
                    )";
            $query=$conexion->prepare($sql);
            $query->execute([
                ":existente"=>$existente,
                ":nuevo"=>$nuevo,
                ":existenteVerif"=>$existente,
                ":nuevoVerif"=>$nuevo,
            ]);
            $sql = "DELETE FROM destino
                    WHERE nombreDest=:nuevo
                    AND estado=0";
            $query=$conexion->prepare($sql);
            $query->execute([
                ":nuevo"=>$nuevo
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
    public static function admitirDestino(string $nuevo):bool{
        try{
            $conexion = BDconection::conectar("user");
            $sql = "UPDATE destino
                    SET estado=1
                    WHERE 
                    nombreDest=:nuevo
                    AND estado=0";
            $query=$conexion->prepare($sql);
            $query->execute([
                ":nuevo"=>$nuevo
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
    public static function eliminarDestino(string $nombreDest):bool{
        try{
            $conexion = BDconection::conectar("user");
            $sql = "DELETE FROM destino
                    WHERE 
                    nombreDest=:nombre
                    AND estado=0";
            $query=$conexion->prepare($sql);
            $query->execute([
                ":nombre"=>$nombreDest
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
    public static function crearDestino(string $destino, string $descripcion){
        try{
            $destino=strtolower($destino);
            $descripcion=strtolower($descripcion);
            $conexion = BDconection::conectar("user");
            $sql = "INSERT INTO destino 
            (nombreDest,
            descr,
            estado)
            VALUES (:destino,:descripcion,0)";
            $query=$conexion->prepare($sql);
            $query->execute([
                ":destino"=>$destino,
                ":descripcion"=>$descripcion
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