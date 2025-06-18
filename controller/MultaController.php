<?php
// Este archivo define la clase MultaController, que actúa como intermediario entre la capa de acceso a datos (MultaDAO) y la lógica de negocio.
// Proporciona métodos para realizar operaciones CRUD relacionadas con las multas.

require_once __DIR__ . '/../accessoDatos/MultaDAO.php';

class MultaController {
    private $multaDAO;

    // Constructor: Inicializa la instancia de MultaDAO
    public function __construct() {
        $this->multaDAO = new MultaDAO();
    }

    // Método para obtener todas las multas
    public function obtenerTodos() {
        // Llama al método getAll() de MultaDAO para recuperar todas las multas
        return $this->multaDAO->getAll();
    }

    // Método para obtener una multa por su ID
    public function obtenerPorId($id) {
        // Llama al método getById() de MultaDAO para recuperar una multa específica
        return $this->multaDAO->getById($id);
    }

    // Método para crear una nueva multa
    public function crear($data) {
        // Validaciones básicas de los datos recibidos
        if (empty($data['id_prestamo']) || empty($data['monto']) || !isset($data['pagado'])) {
            return ['error' => 'Todos los campos son requeridos'];
        }

        // Convertir el arreglo en un objeto Multa
        $multa = new Multa(null, $data['id_prestamo'], $data['monto'], $data['pagado']);
        return $this->multaDAO->insert($multa);
    }

    // Método para actualizar una multa existente
    public function actualizar($data) {
        // Validaciones básicas de los datos recibidos
        if (empty($data['id_multa']) || empty($data['id_prestamo']) || empty($data['monto']) || !isset($data['pagado'])) {
            return ['error' => 'Todos los campos son requeridos'];
        }

        // Convertir el arreglo en un objeto Multa
        $multa = new Multa($data['id_multa'], $data['id_prestamo'], $data['monto'], $data['pagado']);
        return $this->multaDAO->update($multa);
    }

    // Método para eliminar una multa por su ID
    public function eliminar($id) {
        // Llama al método delete() de MultaDAO para eliminar la multa
        return $this->multaDAO->delete($id);
    }
}
?>
