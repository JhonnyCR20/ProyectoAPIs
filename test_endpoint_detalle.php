<?php
// Test directo del endpoint detallePrestamos.php
echo "=== PRUEBA DIRECTA DEL ENDPOINT ===\n\n";

// Simular GET request
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/ProyectoAPIs/view/API/detallePrestamos.php';

// Capturar la salida del endpoint
ob_start();
include 'view/API/detallePrestamos.php';
$output = ob_get_clean();

echo "Salida del endpoint:\n";
echo $output . "\n\n";

// Verificar si es JSON válido
$decoded = json_decode($output, true);
if ($decoded === null) {
    echo "ERROR: La salida no es JSON válido\n";
    echo "Error: " . json_last_error_msg() . "\n";
    echo "Primeros 200 caracteres de la salida:\n";
    echo substr($output, 0, 200) . "\n";
} else {
    echo "ÉXITO: La salida es JSON válido\n";
    echo "Número de elementos: " . (is_array($decoded) ? count($decoded) : 'No es array') . "\n";
}

echo "\n=== FIN DE LA PRUEBA ===\n";
?>
