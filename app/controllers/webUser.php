<?php
// require_once "../config.php";
if (__FILE__ == get_included_files()[0]) {
    require_once "../models/usuario.php";
    require_once "../models/afiliado.php";
    require_once "../models/rol.php";
    require_once "BDconection.php";
    
}else{
    require_once "../app/models/usuario.php";
    require_once "../app/models/afiliado.php";
    require_once "../app/models/rol.php";
    require_once "../app/controllers/BDconection.php";
}
/* esta clase se utilizará para gestionar las acciones
del usuario de la aplicacion, no esta relacionada 
directamente con ninguna tabla de la BD
*/

class WebUser{
    
    private string $ip;
    private Usuario|Afiliado $usuario;

    public function __construct(){
        $this->ip=WebUser::getUserIP();
    }
    public function isAdmin():bool{
        return $this->usuario->getRol()=="admin";
    }
    public function isModer():bool{
        return $this->usuario->getRol()=="moderador" || $this->isAdmin();;
    }
    public function iniciarSesion(string $correo,string $psw, ?string $googleID){
        // print_r(json_encode($googleID));
        // exit();
        $conexion = BDconection::conectar("user");
        $sql = "SELECT 
                correo,
                nombreUsuario as nombre,
                contrasena as psw,
                sancion,
                verificado,
                imagen,
                valoracion,
                google_id as gid,
                nombreRol as rol,
                privilegios
                FROM usuario NATURAL JOIN rol 
                WHERE correo=:correo";
        $query = $conexion->prepare($sql);
        $query->execute([":correo"=>$correo]);
        $result = $query->fetch();
        // print_r( $result);
        if ($result) {
            $gid=false;
            // print_r(json_encode($googleID));
            // exit();

            if ($googleID!=NULL)
                $gid=password_verify($googleID,$result["gid"]);
            if (password_verify($psw,$result["psw"]) || $gid)
            {
                $sqlAfiliado="SELECT firmaAnon,fechaN,TFA,nombrePais,nombreProv,nombreLoc,estado
                                FROM afiliado NATURAL JOIN localidad
                                WHERE correo=:correo";
                $query = $conexion->prepare($sqlAfiliado);
                $query->execute([":correo"=>$correo]);
                $result2=($query->fetch());
                if ($result2){
                    $this->usuario = new Afiliado($result["correo"],$result["nombre"],$result["sancion"],$result["verificado"],$result["imagen"],$result["valoracion"],$result2["nombre"],$result2["firmaAnon"],$result2["fechaN"],$result2["TFA"],new Localidad(new Provincia ($result2["nombrePais"],$result2["nombreProv"]),$result2["nombreLoc"],$result2["estado"])) ;
                }else{
                    $this->usuario = new Usuario($result["correo"],$result["nombre"],$result["sancion"],$result["verificado"],$result["imagen"],$result["valoracion"],new Rol ($result["rol"],$result["privilegios"]));
                }
                return TRUE;
            }
        }
        return FALSE;
    }
    private static function getUserIP() {

        // Check for shared internet/ISP IP
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        // Check for IPs passing through proxies
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        // Check for the remote address
        else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
    public function getIP():string{
        return $this->ip;
    }
    public function getUsuario():Usuario|Afiliado|bool{
        if (isset($this->usuario) && ($this->usuario instanceof Usuario || $this->usuario instanceof Afiliado))
            return $this->usuario;
        return FALSE;
    }
    // public function registrarse(string $correo){
    //     if(!filter_var($correo,FILTER_VALIDATE_EMAIL)){
    //         return FALSE;
    //     }
    //     $conexion=BDconection::conectar("user");
    //     $sql = "SELECT correo FROM usuario WHERE correo=:correo";
    //     $query = $conexion->prepare($sql);
    //     $query->execute([":correo"=>$correo]);
    //     $result = $query->fetch();
    //     if ($result){
    //         print_r(json_encode(
    //             [
    //                 "status"=> "failed",
    //                 "reason" => "Email already used"
    //             ]
    //         ));
    //         $query->closeCursor();
    //         $conexion=NULL;
    //         return FALSE;
    //     }
    //     $sql="INSERT INTO usuario (correo,sancion,verificado) VALUES (:correo,0,0)";
    //     $query=$conexion->prepare($sql);
    //     if ($result=$query->execute([":correo"=>$correo])){
    //         print_r(json_encode(
    //             [
    //                 "status"=> "success"
    //             ]
    //         ));
    //         // aca hay que enviar mail de confirmacion con un enlace para que ingrese la persona
    //         // y verifique la cuenta
    //         $query->closeCursor();
    //         $conexion=NULL;
    //         return TRUE;
    //     }
    // }
}

if (__FILE__ == get_included_files()[0]) {
    echo" Este código solo se ejecutará si este archivo es el principal";
    $a= new WebUser();
    // $a->getUsuario();
    // $a->iniciarSesion("santigimenez.20020817@gmail.com");
    // echo $a->registrarse("sanarraati@gmal.com");
} 



