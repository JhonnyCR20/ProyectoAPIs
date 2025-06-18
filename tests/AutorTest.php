<?php
// Este archivo contiene pruebas unitarias para la clase Autor.
// Se verifica la creación de objetos Autor y la correcta inicialización de sus atributos.

require_once __DIR__ . '/../models/Autor.php';

class AutorTest {
    // Método para probar la creación de un objeto Autor
    public function testAutorCreation() {
        $autor = new Autor(1, 'Gabriel García Márquez', 'Colombiana');
        assert($autor->id_autor === 1);
        assert($autor->nombre === 'Gabriel García Márquez');
        assert($autor->nacionalidad === 'Colombiana');
        echo "AutorTest passed.\n";
    }
}

$test = new AutorTest();
$test->testAutorCreation();
?>
