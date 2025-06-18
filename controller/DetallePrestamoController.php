<?php
require_once __DIR__ . '/../accessoDatos/DetallePrestamoDAO.php';

class DetallePrestamoController {
    // Atributo privado para interactuar con la capa de acceso a datos
    private $detallePrestamoDAO;

    // Constructor: Inicializa la instancia de DetallePrestamoDAO
    public function __construct() {
        $this->detallePrestamoDAO = new DetallePrestamoDAO();
    }

    // Método para obtener todos los detalles de préstamo
    public function obtenerTodos() {
        return $this->detallePrestamoDAO->getAll();
    }

    // Método para obtener un detalle de préstamo por su ID
    public function obtenerPorId($id) {
        return $this->detallePrestamoDAO->getById($id);
    }

    // Método para crear un nuevo detalle de préstamo
    public function crear($detalle) {
        // Validaciones básicas de los datos recibidos
        if (empty($detalle['id_prestamo']) || empty($detalle['id_libro']) || empty($detalle['cantidad'])) {
            return ['error' => 'Todos los campos son requeridos'];
        }
        return $this->detallePrestamoDAO->insert($detalle);
    }

    // Método para actualizar un detalle de préstamo existente
    public function actualizar($detalle) {
        // Validaciones básicas de los datos recibidos
        if (empty($detalle['id_detalle']) || empty($detalle['id_prestamo']) || empty($detalle['id_libro']) || empty($detalle['cantidad'])) {
            return ['error' => 'Todos los campos son requeridos'];
        }
        return $this->detallePrestamoDAO->update($detalle);
    }

    // Método para eliminar un detalle de préstamo por su ID
    public function eliminar($id) {
        return $this->detallePrestamoDAO->delete($id);
    }
}
?>
