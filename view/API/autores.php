<?php
// Este archivo define un endpoint para gestionar autores mediante la clase AutorController.
// Permite realizar operaciones CRUD (Crear, Leer, Actualizar, Eliminar) a través de métodos HTTP.

require_once __DIR__ . '/../../controller/AutorController.php';

$autorController = new AutorController();

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

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}


switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        // Obtiene todos los autores o uno específico según el parámetro 'id'
        if (isset($_GET['id'])) {
            echo json_encode($autorController->obtenerPorId($_GET['id']));
        } else {
            echo json_encode($autorController->obtenerTodos());
        }
        break;

    case 'POST':
        // Crea un nuevo autor con los datos proporcionados en el cuerpo de la solicitud
        $data = json_decode(file_get_contents('php://input'), true);
        echo json_encode($autorController->crear($data));
        break;

    case 'PUT':
        // Actualiza un autor existente según el parámetro 'id'
        if (isset($_GET['id'])) {
            $data = json_decode(file_get_contents('php://input'), true);
            $data['id_autor'] = $_GET['id'];
            echo json_encode($autorController->actualizar($data));
        }
        break;

    case 'DELETE':
        // Elimina un autor según el parámetro 'id'
        if (isset($_GET['id'])) {
            echo json_encode($autorController->eliminar($_GET['id']));
        }
        break;

    default:
        // Responde con un error si el método HTTP no es permitido
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
        break;
}
?>
