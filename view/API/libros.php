<?php
// Este archivo define un endpoint para gestionar libros mediante la clase LibroApiController.
// Habilita CORS y delega la lógica de procesamiento a la clase controladora.

require_once __DIR__ . '/../../controller/LibroApiController.php';

// Habilitar CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

// Obtener el método HTTP
$metodo = $_SERVER['REQUEST_METHOD'];

// Obtener el ID si existe
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path_parts = explode('/', $path);
$id = null;
if (isset($path_parts[count($path_parts)-1]) && is_numeric($path_parts[count($path_parts)-1])) {
    $id = $path_parts[count($path_parts)-1];
}

// Procesar la petición
$controller = new LibroApiController();
$controller->procesarPeticion($metodo, $id);
?>
