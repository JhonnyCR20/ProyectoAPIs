<?php
// Este archivo define la clase ReservaController, que actúa como intermediario entre la capa de acceso a datos (ReservaDAO) y la lógica de negocio.
// Proporciona métodos para realizar operaciones CRUD relacionadas con las reservas.

require_once __DIR__ . '/../accessoDatos/ReservaDAO.php';
require_once __DIR__ . '/HistorialController.php';

class ReservaController {
    private $reservaDAO;

    // Constructor: Inicializa la instancia de ReservaDAO
    public function __construct() {
        $this->reservaDAO = new ReservaDAO();
    }

    // Método para obtener todas las reservas
    public function obtenerTodos() {
        // Llama al método getAll() de ReservaDAO para recuperar todas las reservas
        return $this->reservaDAO->getAll();
    }

    // Método para obtener una reserva por su ID
    public function obtenerPorId($id) {
        // Llama al método getById() de ReservaDAO para recuperar una reserva específica
        return $this->reservaDAO->getById($id);
    }

    // Método para crear una nueva reserva
    public function crear($data) {
        // Validaciones básicas de los datos recibidos
        if (empty($data['id_lector']) || empty($data['id_libro']) || empty($data['fecha_reserva']) || empty($data['estado'])) {
            return ['error' => 'Todos los campos son requeridos'];
        }

        // Convertir el arreglo en un objeto Reserva
        $reserva = new Reserva(null, $data['id_lector'], $data['id_libro'], $data['fecha_reserva'], $data['estado']);
        $resultado = $this->reservaDAO->insert($reserva);
        
        // Registrar en historial si fue exitoso
        if ($resultado) {
            // Obtener título del libro para el historial
            require_once __DIR__ . '/../accessoDatos/LibroDAO.php';
            $libroDAO = new LibroDAO();
            $libro = $libroDAO->getById($data['id_libro']);
            $tituloLibro = $libro ? $libro->getTitulo() : "ID: " . $data['id_libro'];
            
            HistorialController::registrarAccion(
                $data['id_lector'], 
                "Reserva creada - Libro: " . $tituloLibro . " - Estado: " . $data['estado']
            );
            return ['success' => 'Reserva creada exitosamente'];
        } else {
            return ['error' => 'No se pudo crear la reserva'];
        }
    }

    // Método para actualizar una reserva existente
    public function actualizar($data) {
        // Validaciones básicas de los datos recibidos
        if (empty($data['id_reserva']) || empty($data['id_lector']) || empty($data['id_libro']) || empty($data['fecha_reserva']) || empty($data['estado'])) {
            return ['error' => 'Todos los campos son requeridos'];
        }

        // Convertir el arreglo en un objeto Reserva
        $reserva = new Reserva($data['id_reserva'], $data['id_lector'], $data['id_libro'], $data['fecha_reserva'], $data['estado']);
        $resultado = $this->reservaDAO->update($reserva);
        
        // Registrar en historial si fue exitoso
        if ($resultado) {
            HistorialController::registrarAccion(
                $data['id_lector'], 
                "Reserva actualizada - ID: " . $data['id_reserva'] . " - Estado: " . $data['estado']
            );
            return ['success' => 'Reserva actualizada exitosamente'];
        } else {
            return ['error' => 'No se pudo actualizar la reserva'];
        }
    }

    // Método para eliminar una reserva por su ID
    public function eliminar($id) {
        // Obtener información de la reserva antes de eliminarla
        $reserva = $this->reservaDAO->getById($id);
        
        // Eliminar la reserva
        $resultado = $this->reservaDAO->delete($id);
        
        // Registrar en historial si fue exitoso y tenemos info de la reserva
        if ($resultado && $reserva) {
            HistorialController::registrarAccion(
                $reserva['id_lector'], 
                "Reserva eliminada - ID: " . $id
            );
            return ['success' => 'Reserva eliminada exitosamente'];
        } else {
            return ['error' => 'No se pudo eliminar la reserva'];
        }
    }
}
?>
