<?php

class Conexion 
{
    // Método estático para establecer la conexión a la base de datos
    public static function conectar(){

        // Parámetros de conexión
        $host = "localhost";
        $db = "grupo6_biblioteca";
        $user = "root";
        $pass = "";
        $charset = "utf8mb4";

        // Construcción del DSN (Data Source Name)
        $dns = "mysql:host=$host;dbname=$db;charset=$charset";

        try {
            // Creación de la instancia PDO para la conexión
            $pdo = new PDO($dns, $user, $pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Configuración de errores
            return $pdo; // Retorna la conexión
        }catch( PDOException $error ){
            // Manejo de errores en la conexión
            die("Error al conectar: ". $error->getMessage() );
        }
    }
}

?>