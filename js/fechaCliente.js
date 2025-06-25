/**
 * Utilidades para manejo de fechas del cliente
 * Incluir este archivo en páginas que interactúan con la API
 */

// Función para obtener fecha y hora actual del cliente en formato MySQL
function obtenerFechaCliente() {
    const ahora = new Date();
    
    // Formatear fecha como YYYY-MM-DD HH:mm:ss
    const año = ahora.getFullYear();
    const mes = String(ahora.getMonth() + 1).padStart(2, '0');
    const dia = String(ahora.getDate()).padStart(2, '0');
    const horas = String(ahora.getHours()).padStart(2, '0');
    const minutos = String(ahora.getMinutes()).padStart(2, '0');
    const segundos = String(ahora.getSeconds()).padStart(2, '0');
    
    return `${año}-${mes}-${dia} ${horas}:${minutos}:${segundos}`;
}

// Función para obtener fecha del cliente con zona horaria
function obtenerFechaClienteConZona() {
    const ahora = new Date();
    const zonaHoraria = Intl.DateTimeFormat().resolvedOptions().timeZone;
    
    return {
        fecha: obtenerFechaCliente(),
        zonaHoraria: zonaHoraria,
        offset: ahora.getTimezoneOffset()
    };
}

// Función para realizar peticiones HTTP con fecha del cliente automática
async function peticionConFechaCliente(url, metodo = 'GET', datos = {}) {
    // Agregar fecha del cliente a los datos si no está presente
    if (metodo !== 'GET' && datos && !datos.fecha) {
        datos.fecha_cliente = obtenerFechaCliente();
    }
    
    const opciones = {
        method: metodo,
        headers: {
            'Content-Type': 'application/json'
        }
    };
    
    if (metodo !== 'GET' && datos) {
        opciones.body = JSON.stringify(datos);
    }
    
    try {
        const response = await fetch(url, opciones);
        return await response.json();
    } catch (error) {
        console.error('Error en petición:', error);
        throw error;
    }
}

// Interceptor para modificar todas las peticiones automáticamente
function interceptarPeticionesAPI() {
    const fetch_original = window.fetch;
    
    window.fetch = async function(url, opciones = {}) {
        // Solo modificar peticiones a la API
        if (url.includes('/view/API/') && opciones.method && opciones.method !== 'GET') {
            try {
                const body = opciones.body ? JSON.parse(opciones.body) : {};
                
                // Agregar fecha del cliente si no existe
                if (!body.fecha) {
                    body.fecha_cliente = obtenerFechaCliente();
                    opciones.body = JSON.stringify(body);
                }
            } catch (e) {
                // Si no se puede parsear el body, continuar sin modificar
            }
        }
        
        return fetch_original(url, opciones);
    };
}

// Función para formatear fecha para mostrar al usuario
function formatearFechaParaMostrar(fechaMySQL) {
    const fecha = new Date(fechaMySQL);
    return fecha.toLocaleString(); // Usa la configuración local del navegador
}

// Auto-ejecutar interceptor cuando se carga el script
if (typeof window !== 'undefined') {
    interceptarPeticionesAPI();
}

// Función específica para registrar en historial manualmente
async function registrarEnHistorial(idLector, accion) {
    return await peticionConFechaCliente('/ProyectoApi/ProyectoAPIs/view/API/historial.php', 'POST', {
        id_lector: idLector,
        accion: accion
    });
}

// Ejemplos de uso:
/*
// 1. Obtener fecha actual del cliente
const fechaActual = obtenerFechaCliente();
console.log(fechaActual); // 2024-06-24 14:30:25

// 2. Realizar petición con fecha automática
peticionConFechaCliente('/ProyectoApi/ProyectoAPIs/view/API/autores.php', 'POST', {
    nombre: 'Nuevo Autor',
    nacionalidad: 'México'
});

// 3. Registrar en historial manualmente
registrarEnHistorial(15, 'Usuario consultó reporte especial');
*/
