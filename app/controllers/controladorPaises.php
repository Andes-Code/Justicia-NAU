<?php
class Paises{
    public static function paisExiste(string $pais):bool{
        try{
            $conexion = BDconection::conectar("user");
            $sql = "SELECT nombrePais
            FROM pais 
            WHERE nombrePais=:pais";
            $query=$conexion->prepare($sql);
            $query->execute([
                ":pais"=>$pais
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