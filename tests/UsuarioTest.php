<?php
// Este archivo contiene pruebas unitarias para la clase Usuario.
// Se verifica la creación de objetos Usuario y la correcta inicialización de sus atributos.

require_once __DIR__ . '/../models/Usuario.php';

class UsuarioTest {
    // Método para probar la creación de un objeto Usuario
    public function testUsuarioCreation() {
        $usuario = new Usuario(1, 'John Doe', 'john@example.com', 'password123', 'admin');
        assert($usuario->id_usuario === 1);
        assert($usuario->nombre === 'John Doe');
        assert($usuario->correo === 'john@example.com');
        assert($usuario->clave === 'password123');
        assert($usuario->rol === 'admin');
        echo "UsuarioTest passed.\n";
    }
}

$test = new UsuarioTest();
$test->testUsuarioCreation();
?>
