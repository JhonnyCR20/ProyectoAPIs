<?php
// Este archivo define un endpoint para gestionar el historial mediante la clase HistorialController.
// Permite realizar operaciones CRUD (Crear, Leer, Actualizar, Eliminar) a través de métodos HTTP.

require_once __DIR__ . '/../../controller/HistorialController.php';

$historialController = new HistorialController();

header('Content-Type: application/json');
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
        // Obtiene todos los registros de historial o uno específico según el parámetro 'id'
        if (isset($_GET['id'])) {
            echo json_encode($historialController->obtenerPorId($_GET['id']));
        } else {
            echo json_encode($historialController->obtenerTodos());
        }
        break;

    case 'POST':
        // Crea un nuevo registro de historial con los datos proporcionados en el cuerpo de la solicitud
        $data = json_decode(file_get_contents('php://input'), true);
        echo json_encode($historialController->crear($data));
        break;

    case 'PUT':
        // Actualiza un registro de historial existente según el parámetro 'id'
        if (isset($_GET['id'])) {
            $data = json_decode(file_get_contents('php://input'), true);
            $data['id_historial'] = $_GET['id'];
            echo json_encode($historialController->actualizar($data));
        }
        break;

    case 'DELETE':
        // Elimina un registro de historial según el parámetro 'id'
        if (isset($_GET['id'])) {
            echo json_encode($historialController->eliminar($_GET['id']));
        }
        break;

    default:
        // Responde con un error si el método HTTP no es permitido
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
        break;
}
?>
