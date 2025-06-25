<?php
// Test simple para verificar el endpoint de detalles de préstamo
echo "=== PRUEBA DEL ENDPOINT DETALLE PRESTAMOS ===\n\n";

// Simular una solicitud GET para obtener todos los detalles
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/ProyectoAPIs/view/API/detallePrestamos.php';

echo "Probando GET todos los detalles de préstamo:\n";
ob_start();
include 'view/API/detallePrestamos.php';
$output = ob_get_clean();
echo $output . "\n\n";

echo "=== FIN DE LA PRUEBA ===\n";
?>
