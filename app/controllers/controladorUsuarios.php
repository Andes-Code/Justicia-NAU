<?php
if (__FILE__ == get_included_files()[0]) {
    require_once "BDconection.php";
    require_once "../models/usuario.php";
    require_once "../models/afiliado.php";
    require_once "../models/rol.php";
}else{
    require_once "../app/controllers/BDconection.php";
    require_once "../app/models/usuario.php";
    require_once "../app/models/afiliado.php";
    require_once "../app/models/rol.php";
}


class Usuarios{

    public static function getUsuarioByCorreo(string $correo):?Usuario{
        if (!filter_var($correo,FILTER_VALIDATE_EMAIL)){
            // echo "Correo no valido";
            return NULL;
        }
        try{
            $conexion = BDconection::conectar("user");
            $sql = "SELECT correo,
            nombreUsuario as nombre,
            sancion,
            verificado,
            imagen,
            valoracion,
            nombreRol as rol,
            privilegios
            FROM usuario NATURAL JOIN rol 
            WHERE correo=:correo";
            $query=$conexion->prepare($sql);
            $query->execute([
                ":correo"=>$correo
            ]);
            if ($result=$query->fetch()){
                return new Usuario($result["correo"],$result["nombre"],$result["sancion"],$result["verificado"],$result["imagen"],$result["valoracion"], new Rol($result["rol"],$result["privilegios"]));
            }else{
                return NULL;
                echo "no se encontro el usuario";
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
        return NULL;
    }
    public static function registrarUsuario(string $correo, string $nombre, string $psw, int $estatuto, string $googleID){#:bool{
        try{
            // print_r(json_encode([$googleID]));
            // exit();
            $correo=strtolower($correo);
            $conexion = BDconection::conectar("user");
            $sql = "INSERT INTO usuario (correo,nombreUsuario,contrasena,sancion,verificado,valoracion,google_id)
                VALUES
                (:correo,:nombre,:contrasena,0,0,0,:gid)";
            $query=$conexion->prepare($sql);
            $query->execute([
                ":correo"=>$correo,
                ":contrasena"=>$psw,
                ":nombre"=>$nombre,
                ":gid"=>$googleID
            ]);
            if ($query->rowCount()==1){
                if ($estatuto==1)
                {
                    $sql = "INSERT INTO 
                    estatuto (correo)
                    VALUES
                    (:correo)";
                    $query=$conexion->prepare($sql);
                    $query->execute([
                        ":correo"=>$correo,
                    ]);
                }
                return TRUE;
            }else{
                return FALSE;
                echo "no se pudo registrar el usuario";
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
    public static function getUsuariosAdmin(string $busqueda):array{
        try{
            $conexion = BDconection::conectar("user");
            $sql = "SELECT
                    correo
                    FROM 
                    usuario
                    WHERE 
                    nombreRol=:busquedaRol
                    OR
                    correo LIKE CONCAT(:busquedaCorreo,'%')
                    OR
                    nombreUsuario LIKE CONCAT(:busquedaNombre,'%')
                    ";
            $query=$conexion->prepare($sql);
            $query->execute([
                ":busquedaCorreo"=>$busqueda,
                ":busquedaNombre"=>$busqueda,
                ":busquedaRol"=>$busqueda
            ]);
            if ($result=$query->fetchAll()){
                $arreglo=[];
                foreach ($result as $usuario)
                {
                    array_push($arreglo,(self::getUsuarioByCorreo($usuario['correo']))->datosAdmin());
                }
                return $arreglo;
            }else{
                return [];
                echo "no se pudo registrar el usuario";
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
    public static function asignarRol(string $rol, string $correo):bool{
        try{
            $conexion = BDconection::conectar("user");
            $sql = "UPDATE usuario
                    SET nombreRol=:rol
                    WHERE correo = :correo";
            $query=$conexion->prepare($sql);
            $query->execute([
                ":rol"=>$rol,
                ":correo"=>$correo
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