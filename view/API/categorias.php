<?php
// Este archivo define un endpoint para gestionar categorías mediante la clase CategoriaController.
// Permite realizar operaciones CRUD (Crear, Leer, Actualizar, Eliminar) a través de métodos HTTP.

require_once __DIR__ . '/../../controller/CategoriaController.php';

$categoriaController = new CategoriaController();

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
        // Obtiene todas las categorías o una específica según el parámetro 'id'
        if ($id) {
            echo json_encode($categoriaController->obtenerPorId($id));
        } else {
            echo json_encode($categoriaController->obtenerTodos());
        }
        break;

    case 'POST':
        // Crea una nueva categoría con los datos proporcionados en el cuerpo de la solicitud
        $data = json_decode(file_get_contents('php://input'), true);
        echo json_encode($categoriaController->crear($data));
        break;

    case 'PUT':
        // Actualiza una categoría existente según el parámetro 'id'
        if ($id) {
            $data = json_decode(file_get_contents('php://input'), true);
            $data['id_categoria'] = $id;
            echo json_encode($categoriaController->actualizar($data));
        }
        break;

    case 'DELETE':
        // Elimina una categoría según el parámetro 'id'
        if ($id) {
            echo json_encode($categoriaController->eliminar($id));
        }
        break;

    default:
        // Responde con un error si el método HTTP no es permitido
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
        break;
}
?>
