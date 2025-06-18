<?php

// Función para probar un endpoint de la API
function testEndpoint($url, $method = 'GET', $data = null) {
    $ch = curl_init(); // Inicializa cURL

    curl_setopt($ch, CURLOPT_URL, $url); // Configura la URL del endpoint
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Configura para recibir la respuesta como string
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method); // Configura el método HTTP (GET, POST, etc.)

    if ($data) {
        // Si hay datos, los envía en formato JSON
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']); // Configura el encabezado
    }

    $response = curl_exec($ch); // Ejecuta la solicitud
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Obtiene el código HTTP de la respuesta

    curl_close($ch); // Cierra cURL

    return [
        'response' => $response, // Respuesta del servidor
        'httpCode' => $httpCode // Código HTTP
    ];
}

// Base URL de los endpoints
$baseUrl = 'http://localhost/ProyectoApi/view/API';

// Lista de endpoints a probar
$endpoints = [
    'usuarios' => ['method' => 'GET'],
    'autores' => ['method' => 'GET'],
    'editoriales' => ['method' => 'GET'],
    'categorias' => ['method' => 'GET'],
    'prestamos' => ['method' => 'GET'],
    'detallePrestamos' => ['method' => 'GET'],
    'reservas' => ['method' => 'GET'],
    'multas' => ['method' => 'GET'],
    'historial' => ['method' => 'GET']
];

// Itera sobre los endpoints y los prueba
foreach ($endpoints as $endpoint => $config) {
    $url = "$baseUrl/$endpoint.php"; // Construye la URL completa
    $result = testEndpoint($url, $config['method']); // Llama a la función para probar el endpoint

    // Muestra los resultados de la prueba
    echo "Testing $endpoint endpoint:\n";
    echo "HTTP Code: " . $result['httpCode'] . "\n";
    echo "Response: " . $result['response'] . "\n\n";
}

?>
