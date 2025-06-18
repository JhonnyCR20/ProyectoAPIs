<?php
require_once __DIR__ . '/../accessoDatos/AutorDAO.php';

class AutorController {
    // Atributo privado para interactuar con la capa de acceso a datos
    private $autorDAO;

    // Constructor: Inicializa la instancia de AutorDAO
    public function __construct() {
        $this->autorDAO = new AutorDAO();
    }

    // Método para obtener todos los autores
    public function obtenerTodos() {
        return $this->autorDAO->getAll();
    }

    // Método para obtener un autor por su ID
    public function obtenerPorId($id) {
        return $this->autorDAO->getById($id);
    }

    // Método para crear un nuevo autor
    public function crear($data) {
        // Validaciones básicas de los datos recibidos
        if (empty($data['nombre']) || empty($data['nacionalidad'])) {
            return ['error' => 'Todos los campos son requeridos'];
        }

        // Convertir el arreglo en un objeto Autor
        $autor = new Autor(null, $data['nombre'], $data['nacionalidad']);
        return $this->autorDAO->insert($autor);
    }

    // Método para actualizar un autor existente
    public function actualizar($data) {
        // Validaciones básicas de los datos recibidos
        if (empty($data['id_autor']) || empty($data['nombre']) || empty($data['nacionalidad'])) {
            return ['error' => 'Todos los campos son requeridos'];
        }

        // Convertir el arreglo en un objeto Autor
        $autor = new Autor($data['id_autor'], $data['nombre'], $data['nacionalidad']);
        return $this->autorDAO->update($autor);
    }

    // Método para eliminar un autor por su ID
    public function eliminar($id) {
        return $this->autorDAO->delete($id);
    }
}
?>
