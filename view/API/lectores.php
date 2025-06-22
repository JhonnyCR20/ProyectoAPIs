<?php
// Este archivo define un endpoint para gestionar lectores mediante la clase LectorApiController.
// Habilita CORS y delega la lógica de procesamiento a la clase controladora.

require_once __DIR__ . '/../../controller/LectorApiController.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Allow all origins
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}
header('Access-Control-Allow-Origin: *'); // Allow all origins
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');


if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

// Obtener el método HTTP
$metodo = $_SERVER['REQUEST_METHOD'];

// Obtener el ID si existe desde los parámetros de consulta
$id = isset($_GET['id']) ? $_GET['id'] : null;

// Procesar la petición
$controller = new LectorApiController();
$controller->procesarPeticion($metodo, $id);
?>
