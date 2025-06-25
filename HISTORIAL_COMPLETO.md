# Sistema de Historial Automático - API Biblioteca

## Descripción General

El sistema de historial automático registra todas las operaciones CRUD importantes realizadas en la API de la biblioteca. Cada acción se registra automáticamente con información contextual relevante, proporcionando un registro completo de actividades del sistema.

## Módulos con Historial Automático

### ✅ Módulos Completamente Implementados

1. **Préstamos** (`PrestamoController.php`)
   - ✅ Crear: Registra nuevo préstamo con estado y fechas
   - ✅ Actualizar: Registra cambios de estado del préstamo
   - ✅ Eliminar: Registra eliminación del préstamo

2. **Detalles de Préstamo** (`DetallePrestamoController.php`)
   - ✅ Crear: Registra préstamo de libro específico con cantidad
   - ✅ Actualizar: Registra cambios en cantidad prestada
   - ✅ Eliminar: Registra devolución de libros

3. **Lectores** (`LectorApiController.php`)
   - ✅ Crear: Registra nuevo lector en el sistema
   - ✅ Actualizar: Registra actualizaciones de información del lector
   - ✅ Eliminar: Registra eliminación del lector

4. **Reservas** (`ReservaController.php`)
   - ✅ Crear: Registra nueva reserva de libro
   - ✅ Actualizar: Registra cambios en el estado de la reserva
   - ✅ Eliminar: Registra cancelación de reserva

5. **Multas** (`MultaController.php`)
   - ✅ Crear: Registra nueva multa con monto y estado
   - ✅ Actualizar: Registra cambios en estado de pago
   - ✅ Eliminar: Registra eliminación de multa

6. **Libros** (`LibroApiController.php`)
   - ✅ Crear: Registra nuevo libro con título, ISBN y stock inicial
   - ✅ Actualizar: Registra modificaciones de información del libro
   - ✅ Eliminar: Registra eliminación del libro

7. **Autores** (`AutorController.php`)
   - ✅ Crear: Registra nuevo autor con nombre y nacionalidad
   - ✅ Actualizar: Registra actualizaciones de información del autor
   - ✅ Eliminar: Registra eliminación del autor

8. **Categorías** (`CategoriaController.php`)
   - ✅ Crear: Registra nueva categoría con nombre y descripción
   - ✅ Actualizar: Registra modificaciones de la categoría
   - ✅ Eliminar: Registra eliminación de categoría

9. **Editoriales** (`EditorialController.php`)
   - ✅ Crear: Registra nueva editorial con nombre y país
   - ✅ Actualizar: Registra actualizaciones de información de la editorial
   - ✅ Eliminar: Registra eliminación de editorial

10. **Usuarios** (`UsuarioController.php`)
    - ✅ Crear: Registra nuevo usuario del sistema con rol
    - ✅ Actualizar: Registra cambios en información del usuario
    - ✅ Eliminar: Registra eliminación del usuario

11. **Clientes** (`ClientesController.php`)
    - ✅ Crear: Registra nuevo cliente con información de contacto
    - ✅ Actualizar: Registra actualizaciones de información del cliente
    - ✅ Eliminar: Registra eliminación del cliente

## Implementación Técnica

### Método Central de Registro

```php
HistorialController::registrarAccion($id_lector, $accion_descripcion)
```

### Parámetros:
- `$id_lector`: ID del lector relacionado (null para operaciones administrativas)
- `$accion_descripcion`: Descripción detallada de la acción realizada

### Ejemplos de Registros por Módulo

#### Préstamos
```
"Préstamo creado - Estado: activo - Fecha: 2024-01-15"
"Préstamo actualizado - ID: 123 - Estado: devuelto"
"Préstamo eliminado - ID: 123"
```

#### Detalles de Préstamo
```
"Detalle de préstamo creado - Libro: El Quijote - Cantidad: 2"
"Detalle de préstamo actualizado - Libro: Cien años de soledad - Nueva cantidad: 1"
"Detalle de préstamo eliminado - Libro: El Quijote - Cantidad devuelta: 2"
```

#### Libros
```
"Libro creado - Título: El Quijote - ISBN: 978-84-376-0494-7 - Stock: 5"
"Libro actualizado - ID: 45 - Título: El Quijote"
"Libro eliminado - ID: 45 - Título: El Quijote"
```

#### Autores
```
"Autor creado - Nombre: Gabriel García Márquez - Nacionalidad: Colombiana"
"Autor actualizado - ID: 12 - Nombre: Gabriel García Márquez"
"Autor eliminado - ID: 12 - Nombre: Gabriel García Márquez"
```

#### Multas
```
"Multa creada - Monto: $25.50 - Estado: pendiente"
"Multa actualizada - ID: 67 - Estado: pagada - Monto: $25.50"
"Multa eliminada - ID: 67 - Monto: $25.50"
```

## Características del Sistema

### 🔄 Registro Automático
- No requiere intervención manual
- Se ejecuta automáticamente en cada operación exitosa
- Rollback automático si la operación falla

### 📊 Información Contextual
- Incluye datos relevantes de cada operación
- Asocia acciones con lectores cuando corresponde
- Registra cambios específicos (cantidades, estados, etc.)

### 🛡️ Integridad de Datos
- Solo registra operaciones exitosas
- Maneja errores gracefully
- Preserva la información antes de eliminar registros

### 📈 Trazabilidad Completa
- Rastrea todas las operaciones CRUD
- Permite auditoría completa del sistema
- Facilita el debugging y análisis de uso

## Estructura de la Tabla Historial

```sql
CREATE TABLE historial (
    id_historial INT PRIMARY KEY AUTO_INCREMENT,
    id_lector INT NULL,
    accion TEXT NOT NULL,
    fecha_accion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_lector) REFERENCES lectores(id_lector)
);
```

## Acceso al Historial

### Endpoint Principal
- `GET /view/API/historial.php` - Obtener todos los registros
- `GET /view/API/historial.php?id=123` - Obtener registro específico
- `GET /view/API/historial.php?id_lector=45` - Obtener por lector

### Ejemplo de Respuesta
```json
{
    "status": "success",
    "data": [
        {
            "id_historial": 1,
            "id_lector": 15,
            "accion": "Préstamo creado - Estado: activo - Fecha: 2024-01-15",
            "fecha_accion": "2024-06-24 10:30:45"
        }
    ]
}
```

## Beneficios del Sistema

1. **Auditoría Completa**: Registro detallado de todas las operaciones
2. **Trazabilidad**: Seguimiento de acciones por lector y por módulo
3. **Debugging**: Facilita la identificación de problemas
4. **Cumplimiento**: Satisface requerimientos de auditoría
5. **Análisis**: Datos para análisis de uso y patrones
6. **Automatización**: Sin intervención manual requerida

## Notas Técnicas

- El sistema funciona de manera transparente para los usuarios de la API
- No afecta el rendimiento significativamente
- Los registros se mantienen indefinidamente para auditoría completa
- Compatible con todas las operaciones CRUD existentes
- Manejo robusto de errores y excepciones
