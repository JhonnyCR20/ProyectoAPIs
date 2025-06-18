<?php
// Este archivo contiene pruebas unitarias para la clase UsuarioDAO.
// Se realizan pruebas CRUD (Crear, Leer, Actualizar, Eliminar) para verificar la funcionalidad de la clase.

require_once __DIR__ . '/../accessoDatos/UsuarioDAO.php';

class UsuarioDAOTest {
    private $usuarioDAO;

    // Constructor: Inicializa la instancia de UsuarioDAO
    public function __construct() {
        $this->usuarioDAO = new UsuarioDAO();
    }

    // Método para realizar pruebas CRUD
    public function testCRUD() {
        // Crear usuario
        $usuario = [
            'nombre' => 'Test User',
            'correo' => 'testuser@example.com',
            'clave' => 'password123',
            'rol' => 'admin'
        ];
        $id = $this->usuarioDAO->crear($usuario);
        assert($id > 0, 'Error al crear usuario');

        // Leer usuario
        $usuarioLeido = $this->usuarioDAO->obtenerPorId($id);
        assert($usuarioLeido['nombre'] === 'Test User', 'Error al leer usuario');

        // Actualizar usuario
        $usuario['nombre'] = 'Updated User';
        $this->usuarioDAO->actualizar($id, $usuario);
        $usuarioActualizado = $this->usuarioDAO->obtenerPorId($id);
        assert($usuarioActualizado['nombre'] === 'Updated User', 'Error al actualizar usuario');

        // Eliminar usuario
        $this->usuarioDAO->eliminar($id);
        $usuarioEliminado = $this->usuarioDAO->obtenerPorId($id);
        assert($usuarioEliminado === false, 'Error al eliminar usuario');

        echo "UsuarioDAOTest passed.\n";
    }
}

$test = new UsuarioDAOTest();
$test->testCRUD();
?>
