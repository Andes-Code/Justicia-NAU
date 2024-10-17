<?php
class controladorIPs{
    public static function IPExiste(string $ip):bool{
        try{
            $conexion = BDconection::conectar("user");
            $sql = "SELECT 1
            FROM ipdir
            WHERE 
            ip=:ip
            LIMIT 1";
            $query=$conexion->prepare($sql);
            $query->execute([
                ":ip"=>$ip
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
    public static function insertarIP(string $ip):bool{
        try{
            $conexion = BDconection::conectar("user");
            $sql = "INSERT INTO ipdir (ip)
                    VALUES (:ip)";
            $query=$conexion->prepare($sql);
            $query->execute([
                ":ip"=>$ip
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
}


?>