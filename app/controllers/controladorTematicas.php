<?php
if (__FILE__ == get_included_files()[0]) {
    require_once "BDconection.php";
    
}else{
    require_once "../app/controllers/BDconection.php";
}


class Tematicas{

    // public static function getTematicaByNombre(string $nombre):Tematica{
    //     try{
    //         $conexion = BDconection::conectar("user");
    //         $sql = "SELECT 
    //         nombreTem,
    //         descr
    //         FROM tematica 
    //         WHERE nombreTem=:nombre";
    //         $query=$conexion->prepare($sql);
    //         $query->execute([
    //             ":nombre"=>$nombre
    //         ]);
    //         if ($result=$query->fetch()){
    //             return new Tematica($result["nombreTem"],$result["descr"]);
    //         }else{
    //             echo "no se encontro El tematica";
    //             // app::renderUsuarioNoEncontrado($correo)
    //         }

    //     }catch (PDOException $e) {
    //         // Log error message
    //         error_log('Database error: ' . $e->getMessage());
    //         // Show user-friendly message
    //         echo $e->getMessage();
    //         echo 'Lo sentimos, ha ocurrido un problema. Por favor, inténtelo de nuevo más tarde.';
    //     } catch (Exception $e) {
    //         // Log error message
    //         error_log('General error: ' . $e->getMessage());
    //         // Show user-friendly message
    //         echo $e->getMessage();
    //         echo 'Lo sentimos, ha ocurrido un problema. Por favor, inténtelo de nuevo más tarde.';
    //     }
    // }
    public static function tematicaExiste(string $nombre):bool{
        try{
            $conexion = BDconection::conectar("user");
            $sql = "SELECT COUNT(*) as cont
            FROM tematica 
            WHERE nombreTem=:nombre";
            $query=$conexion->prepare($sql);
            $query->execute([
                ":nombre"=>$nombre
            ]);
            if ($result=$query->fetch()){
                if ($result["cont"]==1)
                    return TRUE;
            }else{
                echo "no se encontro El tematica";
                // app::renderUsuarioNoEncontrado($correo)
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
    public static function getTematicasDePeticionByNumero($numero):array{
        try{
            $conexion = BDconection::conectar("user");
            $sql = "SELECT 
            nombreTem,
            descr,
            estado
            FROM tematica NATURAL JOIN 
                (SELECT nombreTem
                FROM trata
                WHERE nroPet=:numero) AS PeticionTematicas";
            $query=$conexion->prepare($sql);
            $query->execute([
                ":numero"=>$numero
            ]);
            if ($result=$query->fetchAll()){
                $tematicas=[];
                foreach ($result as $tematica){
                    array_push($tematicas, new Tematica ($tematica["nombreTem"],$tematica["descr"],$tematica["estado"]));
                }
                return $tematicas;
            }else{
                // echo "no se encontro la peticion o las tematicas";
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
    public static function modalTematicasExistentes():string{
        try{
            $conexion = BDconection::conectar("user");
            $sql = "SELECT 
            nombreTem,
            descr,
            estado
            FROM tematica 
            WHERE estado=1";
            $query=$conexion->prepare($sql);
            $query->execute();
            if ($result=$query->fetchAll()){
                $div="
                <div class='modal' id='visualizador-tematicas-existentes'>
                    <div class='modal-background'></div>
                        <div class='modal-content' id='contenedor-firmas'>
                        
                    ";
                foreach ($result as $tematica){
                    $div.= (new Tematica ($tematica["nombreTem"],$tematica["descr"],$tematica["estado"]))->enlaceCombinarTematica();
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
    public static function crearTematica(string $tematica, string $descripcion){
        try{
            $tematica=strtolower($tematica);
            $conexion = BDconection::conectar("user");
            $sql = "INSERT INTO tematica 
            (nombreTem,
            descr,
            estado)
            VALUES (:tematica,:descripcion,0)";
            $query=$conexion->prepare($sql);
            $query->execute([
                ":tematica"=>$tematica,
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
    public static function mostrarTematicasAdmin(string $estado){
        try{
            $estados=[
                "nuevas"=>0,
                "existentes"=>1
            ];
            $conexion = BDconection::conectar("user");
            $sql = "SELECT 
            nombreTem,
            descr,
            estado
            FROM tematica 
            WHERE estado=:estado";
            $query=$conexion->prepare($sql);
            $query->execute([
                ":estado"=>$estados[$estado]
            ]);
            if ($result=$query->fetchAll()){
                foreach ($result as $tematica){
                    echo (new Tematica ($tematica["nombreTem"],$tematica["descr"],$tematica["estado"]))->mostrarTematicaAdmin();
                }
                if ($estado="nuevas")
                {
                    echo self::modalTematicasExistentes();
                }
            }else{
                // echo "no se encontro la peticion o las tematicas";
                return;
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
    public static function combinarTematica(string $nueva, string $existente):bool{
        try{
            $conexion = BDconection::conectar("user");
            $sql = "UPDATE trata
                    SET nombreTem = :existente
                    WHERE nombreTem = :nueva
                    AND EXISTS (
                        SELECT 1 
                        FROM tematica 
                        WHERE nombreTem = :existenteVerif
                        AND estado = 1
                    )
                    AND EXISTS (
                        SELECT 1 
                        FROM tematica 
                        WHERE nombreTem = :nuevaVerif
                        AND estado = 0
                    )";
            $query=$conexion->prepare($sql);
            $query->execute([
                ":existente"=>$existente,
                ":nueva"=>$nueva,
                ":existenteVerif"=>$existente,
                ":nuevaVerif"=>$nueva,
            ]);
            $sql = "DELETE FROM tematica
                    WHERE nombreTem=:nueva
                    AND estado=0";
            $query=$conexion->prepare($sql);
            $query->execute([
                ":nueva"=>$nueva
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
    public static function admitirTematica(string $nueva):bool{
        try{
            $conexion = BDconection::conectar("user");
            $sql = "UPDATE tematica
                    SET estado=1
                    WHERE 
                    nombreTem=:nueva
                    AND estado=0";
            $query=$conexion->prepare($sql);
            $query->execute([
                ":nueva"=>$nueva
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
    public static function eliminarTematica(string $nombreTem):bool{
        try{
            $conexion = BDconection::conectar("user");
            $sql = "DELETE FROM tematica
                    WHERE 
                    nombreTem=:nombre
                    AND estado=0";
            $query=$conexion->prepare($sql);
            $query->execute([
                ":nombre"=>$nombreTem
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
}