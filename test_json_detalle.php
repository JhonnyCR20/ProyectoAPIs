<?php
// Test para verificar que la API devuelve JSON válido
header('Content-Type: application/json');

try {
    require_once 'controller/DetallePrestamoController.php';
    
    $controller = new DetallePrestamoController();
    
    // Probar obtener todos los detalles
    echo "Probando obtenerTodos():\n";
    $resultado = $controller->obtenerTodos();
    $json = json_encode($resultado);
    
    if ($json === false) {
        echo "Error al convertir a JSON: " . json_last_error_msg() . "\n";
    } else {
        echo "JSON válido generado: " . substr($json, 0, 100) . "...\n";
        
        // Verificar que se puede decodificar
        $decoded = json_decode($json, true);
        if ($decoded === null) {
            echo "Error al decodificar JSON: " . json_last_error_msg() . "\n";
        } else {
            echo "JSON válido - se puede decodificar correctamente\n";
        }
    }
    
} catch (Exception $e) {
    echo "Error en la prueba: " . $e->getMessage() . "\n";
}
?>
