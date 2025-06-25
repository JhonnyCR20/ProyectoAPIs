<?php
// Script de prueba para el control de stock automático
require_once 'controller/DetallePrestamoController.php';
require_once 'accessoDatos/LibroDAO.php';

echo "=== PRUEBA DE CONTROL DE STOCK AUTOMÁTICO ===\n\n";

try {
    $controller = new DetallePrestamoController();
    $libroDAO = new LibroDAO();
    
    // Verificar stock inicial del libro ID 1 (asumiendo que existe)
    $libro = $libroDAO->getById(1);
    if ($libro) {
        echo "Stock inicial del libro ID 1: " . $libro['cantidad_disponible'] . "\n";
        
        // Intentar crear un detalle de préstamo
        $data = [
            'id_prestamo' => 1,
            'id_libro' => 1,
            'cantidad' => 1
        ];
        
        echo "Creando detalle de préstamo para 1 libro...\n";
        $resultado = $controller->crear($data);
        
        if (isset($resultado['error'])) {
            echo "Error: " . $resultado['error'] . "\n";
        } else {
            echo "Detalle creado exitosamente\n";
            
            // Verificar stock después
            $libroActualizado = $libroDAO->getById(1);
            echo "Stock después del préstamo: " . $libroActualizado['cantidad_disponible'] . "\n";
        }
    } else {
        echo "No se encontró libro con ID 1 para la prueba\n";
    }
    
} catch (Exception $e) {
    echo "Error en la prueba: " . $e->getMessage() . "\n";
}

echo "\n=== FIN DE LA PRUEBA ===\n";
?>
