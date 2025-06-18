<?php

require_once 'Conexion.php'; // Incluye la clase de conexión

try {
    // Intenta establecer la conexión a la base de datos
    $conexion = Conexion::conectar();
    echo "Conexión exitosa a la base de datos."; // Mensaje de éxito
} catch (Exception $e) {
    // Captura y muestra el error si la conexión falla
    echo "Error al conectar a la base de datos: " . $e->getMessage();
}

?>
