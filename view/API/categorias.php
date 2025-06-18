<?php
// Este archivo define un endpoint para gestionar categorías mediante la clase CategoriaController.
// Permite realizar operaciones CRUD (Crear, Leer, Actualizar, Eliminar) a través de métodos HTTP.

require_once __DIR__ . '/../../controller/CategoriaController.php';

$categoriaController = new CategoriaController();

header('Content-Type: application/json');

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        // Obtiene todas las categorías o una específica según el parámetro 'id'
        if (isset($_GET['id'])) {
            echo json_encode($categoriaController->obtenerPorId($_GET['id']));
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
        if (isset($_GET['id'])) {
            $data = json_decode(file_get_contents('php://input'), true);
            $data['id_categoria'] = $_GET['id'];
            echo json_encode($categoriaController->actualizar($data));
        }
        break;

    case 'DELETE':
        // Elimina una categoría según el parámetro 'id'
        if (isset($_GET['id'])) {
            echo json_encode($categoriaController->eliminar($_GET['id']));
        }
        break;

    default:
        // Responde con un error si el método HTTP no es permitido
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
        break;
}
?>
