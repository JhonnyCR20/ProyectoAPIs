<?php
// Este archivo contiene pruebas unitarias para la clase Categoria.
// Se verifica la creación de objetos Categoria y la correcta inicialización de sus atributos.

require_once __DIR__ . '/../models/Categoria.php';

class CategoriaTest {
    // Método para probar la creación de un objeto Categoria
    public function testCategoriaCreation() {
        $categoria = new Categoria(1, 'Ficción', 'Libros de ficción');
        assert($categoria->id_categoria === 1);
        assert($categoria->nombre === 'Ficción');
        assert($categoria->descripcion === 'Libros de ficción');
        echo "CategoriaTest passed.\n";
    }
}

$test = new CategoriaTest();
$test->testCategoriaCreation();
?>
