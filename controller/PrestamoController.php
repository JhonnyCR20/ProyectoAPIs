<?php
// Este archivo define la clase PrestamoController, que actúa como intermediario entre la capa de acceso a datos (PrestamoDAO) y la lógica de negocio.
// Proporciona métodos para realizar operaciones CRUD relacionadas con los préstamos.

require_once __DIR__ . '/../accessoDatos/PrestamoDAO.php';

class PrestamoController {
    private $prestamoDAO;

    // Constructor: Inicializa la instancia de PrestamoDAO
    public function __construct() {
        $this->prestamoDAO = new PrestamoDAO();
    }

    // Método para obtener todos los préstamos
    public function obtenerTodos() {
        // Llama al método getAll() de PrestamoDAO para recuperar todos los préstamos
        return $this->prestamoDAO->getAll();
    }

    // Método para obtener un préstamo por su ID
    public function obtenerPorId($id) {
        // Llama al método getById() de PrestamoDAO para recuperar un préstamo específico
        return $this->prestamoDAO->getById($id);
    }

    // Método para crear un nuevo préstamo
    public function crear($data) {
        // Validaciones básicas de los datos recibidos
        if (empty($data['id_lector']) || empty($data['fecha_prestamo']) || empty($data['fecha_devolucion']) || empty($data['estado'])) {
            return ['error' => 'Todos los campos son requeridos'];
        }

        // Convertir el arreglo en un objeto Prestamo
        $prestamo = new Prestamo(null, $data['id_lector'], $data['fecha_prestamo'], $data['fecha_devolucion'], $data['estado']);
        return $this->prestamoDAO->insert($prestamo);
    }

    // Método para actualizar un préstamo existente
    public function actualizar($data) {
        // Validaciones básicas de los datos recibidos
        if (empty($data['id_prestamo']) || empty($data['id_lector']) || empty($data['fecha_prestamo']) || empty($data['fecha_devolucion']) || empty($data['estado'])) {
            return ['error' => 'Todos los campos son requeridos'];
        }

        // Convertir el arreglo en un objeto Prestamo
        $prestamo = new Prestamo($data['id_prestamo'], $data['id_lector'], $data['fecha_prestamo'], $data['fecha_devolucion'], $data['estado']);
        return $this->prestamoDAO->update($prestamo);
    }

    // Método para eliminar un préstamo por su ID
    public function eliminar($id) {
        // Llama al método delete() de PrestamoDAO para eliminar el préstamo
        return $this->prestamoDAO->delete($id);
    }
}
?>
