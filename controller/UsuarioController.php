<?php
require_once __DIR__ . '/../accessoDatos/UsuarioDAO.php';
require_once __DIR__ . '/HistorialController.php';

class UsuarioController {
    // Atributo privado para interactuar con la capa de acceso a datos
    private $usuarioDAO;

    // Constructor: Inicializa la instancia de UsuarioDAO
    public function __construct() {
        $this->usuarioDAO = new UsuarioDAO();
    }

    // Método para listar todos los usuarios
    public function listar() {
        return $this->usuarioDAO->obtenerTodos();
    }

    // Método para obtener un usuario por su ID
    public function obtener($id) {
        return $this->usuarioDAO->obtenerPorId($id);
    }

    // Método para crear un nuevo usuario
    public function crear($datos) {
        // Validaciones básicas de los datos recibidos
        if (empty($datos['nombre']) || empty($datos['correo']) || empty($datos['clave']) || empty($datos['rol'])) {
            return ['error' => 'Todos los campos son requeridos'];
        }

        // Validación del formato del correo electrónico
        if (!filter_var($datos['correo'], FILTER_VALIDATE_EMAIL)) {
            return ['error' => 'Correo electrónico no válido'];
        }

        // Validación del rol permitido
        if (!in_array($datos['rol'], ['admin', 'bibliotecario', 'lector'])) {
            return ['error' => 'Rol no válido'];
        }

        // Llama al DAO para crear el usuario
        $resultado = $this->usuarioDAO->crear($datos);
        
        // Registrar en historial si fue exitoso
        if ($resultado && is_numeric($resultado)) {
            HistorialController::registrarAccion(
                null, // No hay lector específico para usuarios
                "Usuario creado - Nombre: " . $datos['nombre'] . " - Rol: " . $datos['rol'] . " - Correo: " . $datos['correo']
            );
            return $resultado; // Retorna el ID del usuario creado
        } else {
            return ['error' => 'No se pudo crear el usuario'];
        }
    }

    // Método para actualizar un usuario existente
    public function actualizar($id, $data) {
        // Validaciones básicas de los datos recibidos
        if (empty($id) || empty($data['nombre']) || empty($data['correo'])) {
            return ['error' => 'Todos los campos son requeridos'];
        }

        // Validación del rol si se proporciona
        if (isset($data['rol']) && !in_array($data['rol'], ['admin', 'bibliotecario', 'lector'])) {
            return ['error' => 'Rol no válido'];
        }

        // Convertir el arreglo en un objeto Usuario
        $usuario = [
            'id_usuario' => $id,
            'nombre' => $data['nombre'],
            'correo' => $data['correo'],
            'clave' => isset($data['clave']) ? $data['clave'] : null,
            'rol' => isset($data['rol']) ? $data['rol'] : null
        ];

        // Llama al DAO para actualizar el usuario
        $resultado = $this->usuarioDAO->actualizar($id, $usuario);
        
        // Registrar en historial si fue exitoso
        if ($resultado) {
            HistorialController::registrarAccion(
                null, // No hay lector específico para usuarios
                "Usuario actualizado - ID: " . $id . " - Nombre: " . $data['nombre']
            );
            return ['success' => 'Usuario actualizado exitosamente'];
        } else {
            return ['error' => 'No se pudo actualizar el usuario'];
        }
    }

    // Método para eliminar un usuario por su ID
    public function eliminar($id) {
        // Validación del ID proporcionado
        if (empty($id) || !is_numeric($id)) {
            return ['status' => 'error', 'message' => 'ID inválido o no proporcionado'];
        }

        // Verifica si el usuario existe antes de eliminarlo
        $usuario = $this->usuarioDAO->obtenerPorId($id);
        if (!$usuario) {
            return ['status' => 'error', 'message' => 'Usuario no encontrado'];
        }

        // Llama al DAO para eliminar el usuario
        $resultado = $this->usuarioDAO->eliminar($id);
        if ($resultado) {
            // Registrar en historial si fue exitoso
            HistorialController::registrarAccion(
                null, // No hay lector específico para usuarios
                "Usuario eliminado - ID: " . $id . " - Nombre: " . $usuario['nombre']
            );
            return ['status' => 'success', 'message' => 'Usuario eliminado correctamente'];
        }

        return ['status' => 'error', 'message' => 'Error al eliminar el usuario'];
    }

    // Método para autenticar un usuario
    public function login($correo, $clave) {
        // Validaciones básicas de los datos recibidos
        if (empty($correo) || empty($clave)) {
            return ['error' => 'Correo y contraseña son requeridos'];
        }

        // Llama al DAO para autenticar al usuario
        $usuario = $this->usuarioDAO->autenticar($correo, $clave);
        if ($usuario) {
            // Aquí podrías iniciar sesión o generar un token JWT
            return ['success' => true, 'usuario' => $usuario];
        }

        return ['error' => 'Credenciales inválidas'];
    }
}
?>
