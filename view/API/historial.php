<?php
// Este archivo define un endpoint para gestionar el historial mediante la clase HistorialController.
// Permite realizar operaciones CRUD (Crear, Leer, Actualizar, Eliminar) a través de métodos HTTP.

require_once __DIR__ . '/../../controller/HistorialController.php';

$historialController = new HistorialController();

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
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

// Extraer ID de la URL o del query string
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$pathParts = explode('/', $path);
$id = null;
if (is_numeric(end($pathParts))) {
    $id = end($pathParts);
} elseif (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
}

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        // Obtiene todos los registros de historial o uno específico según el parámetro 'id'
        if ($id) {
            echo json_encode($historialController->obtenerPorId($id));
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
        if ($id) {
            $data = json_decode(file_get_contents('php://input'), true);
            $data['id_historial'] = $id;
            echo json_encode($historialController->actualizar($data));
        }
        break;

    case 'DELETE':
        // Elimina un registro de historial según el parámetro 'id'
        if ($id) {
            echo json_encode($historialController->eliminar($id));
        }
        break;

    default:
        // Responde con un error si el método HTTP no es permitido
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
        break;
}
?>
