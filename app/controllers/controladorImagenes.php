<?php
if (__FILE__ == get_included_files()[0]) {
    require_once "BDconection.php";
    require_once "../models/imagen.php";
}else{
    require_once "../app/controllers/BDconection.php";
    require_once "../app/models/imagen.php";
}


class Imagenes{

    public static function getImagenesByNumeroPeticion(int $numero):?array{
        try{
            $conexion = BDconection::conectar("user");
            // $sql = "SELECT
            //         CONCAT_WS('.', 
            //         nroPet,
            //         nroImg,
            //         extension) as nombreImg
            //         FROM imagen
            //         WHERE 
            //         nroPet=:numero";
            $sql = "SELECT 
                    nroPet,
                    nroImg,
                    extension
                    FROM imagen
                    WHERE 
                    nroPet=:numero";
            $query=$conexion->prepare($sql);
            $query->execute([
                ":numero"=>$numero
            ]);
            if ($result=$query->fetchAll()){
                $imagenes=[];
                foreach ($result as $imagen){
                    array_push($imagenes, new Imagen ($imagen["nroPet"],$imagen["nroImg"],$imagen["extension"]));
                }
                return $imagenes;
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
    public static function cantImagenesPeticion(int $nroPet):int{
        try{
            $conexion = BDconection::conectar("user");
            $sql = "SELECT 
                    COUNT(*) as cantidad
                    FROM imagen
                    WHERE 
                    nroPet=:numero";
            $query=$conexion->prepare($sql);
            $query->execute([
                ":numero"=>$nroPet
            ]);
            if ($result=$query->fetch()){
                return $result["cantidad"];
            }else{
                return 0;
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
    public static function subirImagenesPeticion(int $nroPet, array $imagenes){
        if (Peticiones::peticionExiste($nroPet) && self::cantImagenesPeticion($nroPet)==0)
        {
            try{
                $conexion = BDconection::conectar("user");
                $sql = "INSERT INTO imagen 
                    (nroPet,
                    nroImg,
                    extension)
                    VALUES
                    (:nroPet,
                    :nroImg,
                    :ext)";
                $query=$conexion->prepare($sql);
                $j=1;
                for ($i=0; $i < 4 ; $i++) { 
                    # code...
                    if ($imagenes["name"][$i])
                    {
                        // print_r(json_encode([$imagenes["name"][$i]]));
                        // break;
                        $fileName = $imagenes['name'][$i];
                        $fileNameCmps = explode(".", $fileName);
                        $fileExtension = strtolower(end($fileNameCmps));
                        if ($fileExtension=="jpg" || $fileExtension=="jpeg" || $fileExtension=="png")
                        {
                            $fileTmpPath = $imagenes['tmp_name'][$i];
                            // Generar un nuevo nombre único para el archivo
                            $newFileName = $nroPet . '.' . $j . '.' . $fileExtension;
                            // Definir el directorio donde se guardará el archivo
                            $uploadFileDir = './images/';
                            $dest_path = $uploadFileDir . $newFileName;
                            // Verificar si el directorio de destino existe y es escribible
                            if (!is_dir($uploadFileDir)) {
                                mkdir($uploadFileDir, 0777, true);
                            }
                            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                                $query->execute([
                                    ":nroPet"=>$nroPet,
                                    ":nroImg"=>$j,
                                    ":ext"=>$fileExtension
                                ]);
                                // echo 'El archivo se ha subido exitosamente con el nuevo nombre: ' . $newFileName;
                            } 
                            $j++;
                            // else {
                            //     echo 'Hubo un error moviendo el archivo subido';
                            // }
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
    }
}