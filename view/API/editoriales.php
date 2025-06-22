<?php
// Este archivo define un endpoint para gestionar editoriales mediante la clase EditorialController.
// Permite realizar operaciones CRUD (Crear, Leer, Actualizar, Eliminar) a través de métodos HTTP.

require_once __DIR__ . '/../../controller/EditorialController.php';

$editorialController = new EditorialController();

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


switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        // Obtiene todas las editoriales o una específica según el parámetro 'id'
        if (isset($_GET['id'])) {
            echo json_encode($editorialController->obtenerPorId($_GET['id']));
        } else {
            echo json_encode($editorialController->obtenerTodos());
        }
        break;

    case 'POST':
        // Crea una nueva editorial con los datos proporcionados en el cuerpo de la solicitud
        $data = json_decode(file_get_contents('php://input'), true);
        echo json_encode($editorialController->crear($data));
        break;

    case 'PUT':
        // Actualiza una editorial existente según el parámetro 'id'
        if (isset($_GET['id'])) {
            $data = json_decode(file_get_contents('php://input'), true);
            $data['id_editorial'] = $_GET['id'];
            echo json_encode($editorialController->actualizar($data));
        }
        break;

    case 'DELETE':
        // Elimina una editorial según el parámetro 'id'
        if (isset($_GET['id'])) {
            echo json_encode($editorialController->eliminar($_GET['id']));
        }
        break;

    default:
        // Responde con un error si el método HTTP no es permitido
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
        break;
}
?>
