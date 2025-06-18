<?php
// Este archivo contiene pruebas unitarias para la clase AutorDAO.
// Se realizan pruebas CRUD (Crear, Leer, Actualizar, Eliminar) para verificar la funcionalidad de la clase.

require_once __DIR__ . '/../accessoDatos/AutorDAO.php';

class AutorDAOTest {
    private $autorDAO;

    // Constructor: Inicializa la instancia de AutorDAO
    public function __construct() {
        $this->autorDAO = new AutorDAO();
    }

    // Método para realizar pruebas CRUD
    public function testCRUD() {
        // Crear autor
        $autor = new Autor(null, 'Test Author', 'Test Country');
        $id = $this->autorDAO->insert($autor);
        assert($id > 0, 'Error al crear autor');

        // Leer autor
        $autorLeido = $this->autorDAO->getById($id);
        assert($autorLeido->nombre === 'Test Author', 'Error al leer autor');

        // Actualizar autor
        $autor->id_autor = $id;
        $autor->nombre = 'Updated Author';
        $this->autorDAO->update($autor);
        $autorActualizado = $this->autorDAO->getById($id);
        assert($autorActualizado->nombre === 'Updated Author', 'Error al actualizar autor');

        // Eliminar autor
        $this->autorDAO->delete($id);
        $autorEliminado = $this->autorDAO->getById($id);
        assert($autorEliminado === null, 'Error al eliminar autor');

        echo "AutorDAOTest passed.\n";
    }
}

$test = new AutorDAOTest();
$test->testCRUD();
?>
