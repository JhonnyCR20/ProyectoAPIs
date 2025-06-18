<?php
require_once __DIR__ . '/../accessoDatos/CategoriaDAO.php';

class CategoriaController {
    // Atributo privado para interactuar con la capa de acceso a datos
    private $categoriaDAO;

    // Constructor: Inicializa la instancia de CategoriaDAO
    public function __construct() {
        $this->categoriaDAO = new CategoriaDAO();
    }

    // Método para obtener todas las categorías
    public function obtenerTodos() {
        return $this->categoriaDAO->getAll();
    }

    // Método para obtener una categoría por su ID
    public function obtenerPorId($id) {
        return $this->categoriaDAO->getById($id);
    }

    // Método para crear una nueva categoría
    public function crear($data) {
        // Validaciones básicas de los datos recibidos
        if (empty($data['nombre']) || empty($data['descripcion'])) {
            return ['error' => 'Todos los campos son requeridos'];
        }

        // Convertir el arreglo en un objeto Categoria
        $categoria = new Categoria(null, $data['nombre'], $data['descripcion']);
        return $this->categoriaDAO->insert($categoria);
    }

    // Método para actualizar una categoría existente
    public function actualizar($data) {
        // Validaciones básicas de los datos recibidos
        if (empty($data['id_categoria']) || empty($data['nombre']) || empty($data['descripcion'])) {
            return ['error' => 'Todos los campos son requeridos'];
        }

        // Convertir el arreglo en un objeto Categoria
        $categoria = new Categoria($data['id_categoria'], $data['nombre'], $data['descripcion']);
        return $this->categoriaDAO->update($categoria);
    }

    // Método para eliminar una categoría por su ID
    public function eliminar($id) {
        return $this->categoriaDAO->delete($id);
    }
}
?>
