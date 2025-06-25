<?php
require_once __DIR__ . '/../accessoDatos/CategoriaDAO.php';
require_once __DIR__ . '/HistorialController.php';

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
        $resultado = $this->categoriaDAO->insert($categoria);
        
        // Registrar en historial si fue exitoso
        if ($resultado) {
            HistorialController::registrarAccion(
                null, // No hay lector específico para categorías
                "Categoría creada - Nombre: " . $data['nombre'] . " - Descripción: " . $data['descripcion']
            );
            return ['success' => 'Categoría creada exitosamente'];
        } else {
            return ['error' => 'No se pudo crear la categoría'];
        }
    }

    // Método para actualizar una categoría existente
    public function actualizar($data) {
        // Validaciones básicas de los datos recibidos
        if (empty($data['id_categoria']) || empty($data['nombre']) || empty($data['descripcion'])) {
            return ['error' => 'Todos los campos son requeridos'];
        }

        // Convertir el arreglo en un objeto Categoria
        $categoria = new Categoria($data['id_categoria'], $data['nombre'], $data['descripcion']);
        $resultado = $this->categoriaDAO->update($categoria);
        
        // Registrar en historial si fue exitoso
        if ($resultado) {
            HistorialController::registrarAccion(
                null, // No hay lector específico para categorías
                "Categoría actualizada - ID: " . $data['id_categoria'] . " - Nombre: " . $data['nombre']
            );
            return ['success' => 'Categoría actualizada exitosamente'];
        } else {
            return ['error' => 'No se pudo actualizar la categoría'];
        }
    }

    // Método para eliminar una categoría por su ID
    public function eliminar($id) {
        // Obtener información de la categoría antes de eliminarla
        $categoria = $this->categoriaDAO->getById($id);
        
        // Eliminar la categoría
        $resultado = $this->categoriaDAO->delete($id);
        
        // Registrar en historial si fue exitoso y tenemos info de la categoría
        if ($resultado && $categoria) {
            HistorialController::registrarAccion(
                null, // No hay lector específico para categorías
                "Categoría eliminada - ID: " . $id . " - Nombre: " . $categoria['nombre']
            );
            return ['success' => 'Categoría eliminada exitosamente'];
        } else {
            return ['error' => 'No se pudo eliminar la categoría'];
        }
    }
}
?>
