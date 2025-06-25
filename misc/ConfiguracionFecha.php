<?php
// Archivo de configuración de zona horaria para toda la aplicación
date_default_timezone_set('America/Mexico_City');

// Función auxiliar para obtener fecha actual formateada
function obtenerFechaActual() {
    return date('Y-m-d H:i:s');
}

// Función para convertir fecha a zona horaria específica
function convertirZonaHoraria($fecha, $zonaDestino = 'America/Mexico_City') {
    $dt = new DateTime($fecha);
    $dt->setTimezone(new DateTimeZone($zonaDestino));
    return $dt->format('Y-m-d H:i:s');
}
?>
