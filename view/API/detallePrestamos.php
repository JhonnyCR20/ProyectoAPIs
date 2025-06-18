<?php
// Este archivo define un endpoint para gestionar detalles de préstamos mediante la clase DetallePrestamoController.
// Permite realizar operaciones CRUD (Crear, Leer, Actualizar, Eliminar) a través de métodos HTTP.

require_once __DIR__ . '/../../controller/DetallePrestamoController.php';

$detallePrestamoController = new DetallePrestamoController();

header('Content-Type: application/json');

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        // Obtiene todos los detalles de préstamos o uno específico según el parámetro 'id'
        if (isset($_GET['id'])) {
            echo json_encode($detallePrestamoController->obtenerPorId($_GET['id']));
        } else {
            echo json_encode($detallePrestamoController->obtenerTodos());
        }
        break;

    case 'POST':
        // Crea un nuevo detalle de préstamo con los datos proporcionados en el cuerpo de la solicitud
        $data = json_decode(file_get_contents('php://input'), true);
        echo json_encode($detallePrestamoController->crear($data));
        break;

    case 'PUT':
        // Actualiza un detalle de préstamo existente según el parámetro 'id'
        if (isset($_GET['id'])) {
            $data = json_decode(file_get_contents('php://input'), true);
            $data['id_detalle'] = $_GET['id'];
            echo json_encode($detallePrestamoController->actualizar($data));
        }
        break;

    case 'DELETE':
        // Elimina un detalle de préstamo según el parámetro 'id'
        if (isset($_GET['id'])) {
            echo json_encode($detallePrestamoController->eliminar($_GET['id']));
        }
        break;

    default:
        // Responde con un error si el método HTTP no es permitido
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
        break;
}
?>
