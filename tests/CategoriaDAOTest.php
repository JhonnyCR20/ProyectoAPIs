<?php
// Este archivo contiene pruebas unitarias para la clase CategoriaDAO.
// Se realizan pruebas CRUD (Crear, Leer, Actualizar, Eliminar) para verificar la funcionalidad de la clase.

require_once __DIR__ . '/../accessoDatos/CategoriaDAO.php';

class CategoriaDAOTest {
    private $categoriaDAO;

    // Constructor: Inicializa la instancia de CategoriaDAO
    public function __construct() {
        $this->categoriaDAO = new CategoriaDAO();
    }

    // Método para realizar pruebas CRUD
    public function testCRUD() {
        // Crear categoría
        $categoria = new Categoria(null, 'Test Categoria', 'Test Descripcion');
        $id = $this->categoriaDAO->insert($categoria);
        assert($id > 0, 'Error al crear categoría');

        // Leer categoría
        $categoriaLeida = $this->categoriaDAO->getById($id);
        assert($categoriaLeida->nombre === 'Test Categoria', 'Error al leer categoría');

        // Actualizar categoría
        $categoria->id_categoria = $id;
        $categoria->nombre = 'Updated Categoria';
        $this->categoriaDAO->update($categoria);
        $categoriaActualizada = $this->categoriaDAO->getById($id);
        assert($categoriaActualizada->nombre === 'Updated Categoria', 'Error al actualizar categoría');

        // Eliminar categoría
        $this->categoriaDAO->delete($id);
        $categoriaEliminada = $this->categoriaDAO->getById($id);
        assert($categoriaEliminada === null, 'Error al eliminar categoría');

        echo "CategoriaDAOTest passed.\n";
    }
}

$test = new CategoriaDAOTest();
$test->testCRUD();
?>
