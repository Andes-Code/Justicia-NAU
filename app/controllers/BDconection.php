<?php

/* Esta clase estara destinada a la conexion a la base de datos,
no esta directamente relacionada con ninguna tabla
*/

class BDconection{
    private static string $host = "localhost";
    private static string $db = "proy_change";
    private static string $charset = "utf8mb4";
    private static array $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    public static function conectar(string $usuario){
        if ($usuario=="user")
        {
            $user="usuario";
            $psw="commonuser";
        }
        else if ($user="afiliado")
        {
            $user="afiliado";
            $psw="afiliateduser";
        }
        else if ($user="admini")
        {
            $user="afiliado";
            $psw="afiliateduser";
        }else
        {
            return FALSE;
        }
        try{
            $dsn = "mysql:host=".self::$host.";dbname=".self::$db.";charset=".self::$charset;
            $conection = new PDO($dsn,/*$user,$psw*/"root","",self::$options); 
        }catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
        return $conection;
        
    }


    

}