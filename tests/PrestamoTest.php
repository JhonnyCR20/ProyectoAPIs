<?php
// Este archivo contiene pruebas unitarias para la clase Prestamo.
// Se verifica la creación de objetos Prestamo y la correcta inicialización de sus atributos.

require_once __DIR__ . '/../models/Prestamo.php';

class PrestamoTest {
    // Método para probar la creación de un objeto Prestamo
    public function testPrestamoCreation() {
        $prestamo = new Prestamo(1, 2, '2025-06-01', '2025-06-15', 'activo');
        assert($prestamo->id_prestamo === 1);
        assert($prestamo->id_lector === 2);
        assert($prestamo->fecha_prestamo === '2025-06-01');
        assert($prestamo->fecha_devolucion === '2025-06-15');
        assert($prestamo->estado === 'activo');
        echo "PrestamoTest passed.\n";
    }
}

$test = new PrestamoTest();
$test->testPrestamoCreation();
?>
