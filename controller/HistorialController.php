<?php
// Este archivo define la clase HistorialController, que actúa como intermediario entre la capa de acceso a datos (HistorialDAO) y la lógica de negocio.
// Proporciona métodos para realizar operaciones CRUD relacionadas con los registros de historial.

require_once __DIR__ . '/../accessoDatos/HistorialDAO.php';

class HistorialController {
    // Atributo privado para interactuar con la capa de acceso a datos
    private $historialDAO;

    // Constructor: Inicializa la instancia de HistorialDAO
    public function __construct() {
        $this->historialDAO = new HistorialDAO();
    }

    // Método para obtener todos los registros de historial
    public function obtenerTodos() {
        // Llama al método getAll() de HistorialDAO para recuperar todos los registros
        return $this->historialDAO->getAll();
    }

    // Método para obtener un registro de historial por su ID
    public function obtenerPorId($id) {
        // Llama al método getById() de HistorialDAO para recuperar un registro específico
        return $this->historialDAO->getById($id);
    }

    // Método para crear un nuevo registro de historial
    public function crear($data) {
        // Validaciones básicas de los datos recibidos
        if (empty($data['id_lector']) || empty($data['accion']) || empty($data['fecha'])) {
            return ['error' => 'Todos los campos son requeridos'];
        }

        // Convertir el arreglo en un objeto Historial
        $historial = new Historial(null, $data['id_lector'], $data['accion'], $data['fecha']);
        return $this->historialDAO->insert($historial);
    }

    // Método para actualizar un registro de historial existente
    public function actualizar($data) {
        // Validaciones básicas de los datos recibidos
        if (empty($data['id_historial']) || empty($data['id_lector']) || empty($data['accion']) || empty($data['fecha'])) {
            return ['error' => 'Todos los campos son requeridos'];
        }

        // Convertir el arreglo en un objeto Historial
        $historial = new Historial($data['id_historial'], $data['id_lector'], $data['accion'], $data['fecha']);
        return $this->historialDAO->update($historial);
    }

    // Método para eliminar un registro de historial por su ID
    public function eliminar($id) {
        // Llama al método delete() de HistorialDAO para eliminar el registro
        return $this->historialDAO->delete($id);
    }
}
?>
