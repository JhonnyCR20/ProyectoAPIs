<?php
// Este archivo define la clase EditorialController, que actúa como intermediario entre la capa de acceso a datos (EditorialDAO) y la lógica de negocio.
// Proporciona métodos para realizar operaciones CRUD relacionadas con las editoriales.

require_once __DIR__ . '/../accessoDatos/EditorialDAO.php';

class EditorialController {
    // Atributo privado para interactuar con la capa de acceso a datos
    private $editorialDAO;

    // Constructor: Inicializa la instancia de EditorialDAO
    public function __construct() {
        $this->editorialDAO = new EditorialDAO();
    }

    // Método para obtener todas las editoriales
    public function obtenerTodos() {
        // Llama al método getAll() de EditorialDAO para recuperar todas las editoriales
        return $this->editorialDAO->getAll();
    }

    // Método para obtener una editorial por su ID
    public function obtenerPorId($id) {
        // Llama al método getById() de EditorialDAO para recuperar una editorial específica
        return $this->editorialDAO->getById($id);
    }

    // Método para crear una nueva editorial
    public function crear($data) {
        // Validaciones básicas de los datos recibidos
        if (empty($data['nombre']) || empty($data['pais'])) {
            return ['error' => 'Todos los campos son requeridos'];
        }

        // Convertir el arreglo en un objeto Editorial
        $editorial = new Editorial(null, $data['nombre'], $data['pais']);
        return $this->editorialDAO->insert($editorial);
    }

    // Método para actualizar una editorial existente
    public function actualizar($data) {
        // Validaciones básicas de los datos recibidosS
        if (empty($data['id_editorial']) || empty($data['nombre']) || empty($data['pais'])) {
            return ['error' => 'Todos los campos son requeridos'];
        }

        // Convertir el arreglo en un objeto Editorial
        $editorial = new Editorial($data['id_editorial'], $data['nombre'], $data['pais']);
        return $this->editorialDAO->update($editorial);
    }

    // Método para eliminar una editorial por su ID
    public function eliminar($id) {
        // Llama al método delete() de EditorialDAO para eliminar la editorial
        return $this->editorialDAO->delete($id);
    }
}
?>
