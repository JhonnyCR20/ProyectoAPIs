<?php
// Este archivo define un endpoint para gestionar reservas mediante la clase ReservaController.
// Permite realizar operaciones CRUD (Crear, Leer, Actualizar, Eliminar) a través de métodos HTTP.

require_once __DIR__ . '/../../controller/ReservaController.php';

$reservaController = new ReservaController();

header('Content-Type: application/json');

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        // Obtiene todas las reservas o una específica según el parámetro 'id'
        if (isset($_GET['id'])) {
            echo json_encode($reservaController->obtenerPorId($_GET['id']));
        } else {
            echo json_encode($reservaController->obtenerTodos());
        }
        break;

    case 'POST':
        // Crea una nueva reserva con los datos proporcionados en el cuerpo de la solicitud
        $data = json_decode(file_get_contents('php://input'), true);
        echo json_encode($reservaController->crear($data));
        break;

    case 'PUT':
        // Actualiza una reserva existente según el parámetro 'id'
        if (isset($_GET['id'])) {
            $data = json_decode(file_get_contents('php://input'), true);
            $data['id_reserva'] = $_GET['id'];
            echo json_encode($reservaController->actualizar($data));
        }
        break;

    case 'DELETE':
        // Elimina una reserva según el parámetro 'id'
        if (isset($_GET['id'])) {
            echo json_encode($reservaController->eliminar($_GET['id']));
        }
        break;

    default:
        // Responde con un error si el método HTTP no es permitido
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
        break;
}
?>
