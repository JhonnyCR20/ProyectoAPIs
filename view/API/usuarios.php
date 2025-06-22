<?php
// Este archivo define un endpoint para gestionar usuarios mediante la clase UsuarioController.
// Habilita CORS y permite realizar operaciones CRUD (Crear, Leer, Actualizar, Eliminar) a través de métodos HTTP.

require_once "../../controller/UsuarioController.php";

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

$controller = new UsuarioController();
$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$pathParts = explode('/', $path);
$id = null;

// Obtener ID si existe en la URL
if (isset($pathParts[count($pathParts)-1]) && is_numeric($pathParts[count($pathParts)-1])) {
    $id = $pathParts[count($pathParts)-1];
}

// Obtener ID desde parámetros de consulta si no está en la URL
if (!$id && isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
}

try {
    switch ($method) {
        case 'GET':
            // Obtiene todos los usuarios o uno específico según el parámetro 'id'
            if ($id) {
                $result = $controller->obtener($id);
                if ($result) {
                    echo json_encode(['status' => 'success', 'data' => $result]);
                } else {
                    http_response_code(404);
                    echo json_encode(['status' => 'error', 'message' => 'Usuario no encontrado']);
                }
            } else {
                $result = $controller->listar();
                echo json_encode(['status' => 'success', 'data' => $result]);
            }
            break;

        case 'POST':
            $data = json_decode(file_get_contents('php://input'), true);
            
            // Manejo especial para el endpoint de login
            if (isset($pathParts[count($pathParts)-1]) && $pathParts[count($pathParts)-1] == 'login') {
                $result = $controller->login($data['correo'], $data['clave']);
                if (isset($result['error'])) {
                    http_response_code(401);
                    echo json_encode(['status' => 'error', 'message' => $result['error']]);
                } else {
                    echo json_encode(['status' => 'success', 'data' => $result]);
                }
                break;
            }

            $result = $controller->crear($data);
            if (isset($result['error'])) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => $result['error']]);
            } else {
                http_response_code(201);
                echo json_encode(['status' => 'success', 'message' => 'Usuario creado', 'id' => $result]);
            }
            break;

        case 'PUT':
            // Actualiza un usuario existente según el parámetro 'id'
            if ($id) {
                $data = json_decode(file_get_contents('php://input'), true);
                $result = $controller->actualizar($id, $data);
                echo json_encode(['status' => 'success', 'data' => $result]);
            } else {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'ID requerido para actualizar']);
            }
            break;

        case 'DELETE':
            // Elimina un usuario según el parámetro 'id'
            if ($id) {
                $result = $controller->eliminar($id);
                echo json_encode(['status' => 'success', 'data' => $result]);
            } else {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'ID requerido para eliminar']);
            }
            break;

        default:
            // Responde con un error si el método HTTP no es permitido
            http_response_code(405);
            echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
            break;
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
