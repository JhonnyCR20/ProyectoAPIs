<?php
// Este archivo contiene pruebas unitarias para la clase PrestamoDAO.
// Se realizan pruebas CRUD (Crear, Leer, Actualizar, Eliminar) para verificar la funcionalidad de la clase.

require_once __DIR__ . '/../accessoDatos/PrestamoDAO.php';

class PrestamoDAOTest {
    private $prestamoDAO;

    // Constructor: Inicializa la instancia de PrestamoDAO
    public function __construct() {
        $this->prestamoDAO = new PrestamoDAO();
    }

    // Método para realizar pruebas CRUD
    public function testCRUD() {
        // Crear préstamo
        $prestamo = new Prestamo(null, 1, '2025-06-01', '2025-06-15', 'activo');
        $id = $this->prestamoDAO->insert($prestamo);
        assert($id > 0, 'Error al crear préstamo');

        // Leer préstamo
        $prestamoLeido = $this->prestamoDAO->getById($id);
        assert($prestamoLeido->estado === 'activo', 'Error al leer préstamo');

        // Actualizar préstamo
        $prestamo->id_prestamo = $id;
        $prestamo->estado = 'devuelto';
        $this->prestamoDAO->update($prestamo);
        $prestamoActualizado = $this->prestamoDAO->getById($id);
        assert($prestamoActualizado->estado === 'devuelto', 'Error al actualizar préstamo');

        // Eliminar préstamo
        $this->prestamoDAO->delete($id);
        $prestamoEliminado = $this->prestamoDAO->getById($id);
        assert($prestamoEliminado === null, 'Error al eliminar préstamo');

        echo "PrestamoDAOTest passed.\n";
    }
}

$test = new PrestamoDAOTest();
$test->testCRUD();
?>
