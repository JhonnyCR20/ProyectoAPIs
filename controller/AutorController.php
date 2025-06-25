<?php
require_once __DIR__ . '/../accessoDatos/AutorDAO.php';
require_once __DIR__ . '/HistorialController.php';

class AutorController
{
    // Atributo privado para interactuar con la capa de acceso a datos
    private $autorDAO;

    // Constructor: Inicializa la instancia de AutorDAO
    public function __construct()
    {
        $this->autorDAO = new AutorDAO();
    }

    // Método para obtener todos los autores
    public function obtenerTodos()
    {
        $autores = $this->autorDAO->getAll();
        // Convertir cada objeto Autor a array asociativo
        return array_map(function ($autor) {
            return [
                'id_autor' => $autor->id_autor,
                'nombre' => $autor->nombre,
                'nacionalidad' => $autor->nacionalidad
            ];
        }, $autores);
    }

    // Método para obtener un autor por su ID
    public function obtenerPorId($id)
    {
        return $this->autorDAO->getById($id);
    }

    // Método para crear un nuevo autor
    public function crear($data)
    {
        // Validaciones básicas de los datos recibidos
        if (empty($data['nombre']) || empty($data['nacionalidad'])) {
            return ['error' => 'Todos los campos son requeridos'];
        }

        // Convertir el arreglo en un objeto Autor
        $autor = new Autor(null, $data['nombre'], $data['nacionalidad']);
        $resultado = $this->autorDAO->insert($autor);
        
        // Registrar en historial si fue exitoso
        if ($resultado) {
            HistorialController::registrarAccion(
                null, // No hay lector específico para autores
                "Autor creado - Nombre: " . $data['nombre'] . " - Nacionalidad: " . $data['nacionalidad']
            );
            return ['success' => 'Autor creado exitosamente'];
        } else {
            return ['error' => 'No se pudo crear el autor'];
        }
    }

    // Método para actualizar un autor existente
    public function actualizar($data)
    {
        // Validaciones básicas de los datos recibidos
        if (empty($data['id_autor']) || empty($data['nombre']) || empty($data['nacionalidad'])) {
            return ['error' => 'Todos los campos son requeridos'];
        }

        // Convertir el arreglo en un objeto Autor
        $autor = new Autor($data['id_autor'], $data['nombre'], $data['nacionalidad']);
        $resultado = $this->autorDAO->update($autor);
        
        // Registrar en historial si fue exitoso
        if ($resultado) {
            HistorialController::registrarAccion(
                null, // No hay lector específico para autores
                "Autor actualizado - ID: " . $data['id_autor'] . " - Nombre: " . $data['nombre']
            );
            return ['success' => 'Autor actualizado exitosamente'];
        } else {
            return ['error' => 'No se pudo actualizar el autor'];
        }
    }

    // Método para eliminar un autor por su ID
    public function eliminar($id)
    {
        // Obtener información del autor antes de eliminarlo
        $autor = $this->autorDAO->getById($id);
        
        // Eliminar el autor
        $resultado = $this->autorDAO->delete($id);
        
        // Registrar en historial si fue exitoso y tenemos info del autor
        if ($resultado && $autor) {
            HistorialController::registrarAccion(
                null, // No hay lector específico para autores
                "Autor eliminado - ID: " . $id . " - Nombre: " . $autor['nombre']
            );
            return ['success' => 'Autor eliminado exitosamente'];
        } else {
            return ['error' => 'No se pudo eliminar el autor'];
        }
    }
}
