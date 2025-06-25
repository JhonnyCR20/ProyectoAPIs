# Control de Stock Automático en Detalles de Préstamo

## Descripción
Se ha implementado el control automático de stock de libros en el controlador de `DetallePrestamo`. Ahora, cuando se realizan operaciones CRUD en los detalles de préstamo, el stock de los libros se actualiza automáticamente.

## ¿Qué cambió?

### Nuevas funcionalidades:
1. **Al crear un detalle de préstamo**: Se valida y reduce automáticamente el stock del libro
2. **Al actualizar un detalle de préstamo**: Se ajusta el stock según el cambio en la cantidad
3. **Al eliminar un detalle de préstamo**: Se devuelve el stock al libro automáticamente

### Métodos agregados en LibroDAO.php:
- `reducirStock($idLibro, $cantidad)`: Reduce el stock disponible de un libro
- `aumentarStock($idLibro, $cantidad)`: Aumenta el stock disponible de un libro

## Ejemplos de uso

### 1. Crear detalle de préstamo (con control de stock)
```
POST /view/API/detallePrestamos.php
Content-Type: application/json

{
    "id_prestamo": 1,
    "id_libro": 5,
    "cantidad": 2
}
```

**Resultado exitoso:**
- Se crea el detalle de préstamo
- Se reduce el stock del libro con ID 5 en 2 unidades
- Respuesta: `{"success": "Detalle de préstamo creado exitosamente"}`

**Si no hay stock suficiente:**
- No se crea el detalle de préstamo
- Respuesta: `{"error": "Stock insuficiente. Disponible: 1"}`

### 2. Actualizar detalle de préstamo (ajuste de stock)
```
PUT /view/API/detallePrestamos.php/1
Content-Type: application/json

{
    "id_detalle": 1,
    "id_prestamo": 1,
    "id_libro": 5,
    "cantidad": 3
}
```

**Si la cantidad anterior era 2 y ahora es 3:**
- Se actualiza el detalle de préstamo
- Se reduce 1 unidad adicional del stock del libro
- Respuesta: `{"success": "Detalle de préstamo actualizado exitosamente"}`

### 3. Eliminar detalle de préstamo (devolución de stock)
```
DELETE /view/API/detallePrestamos.php/1
```

**Resultado:**
- Se elimina el detalle de préstamo
- Se devuelve el stock al libro (la cantidad que estaba prestada)
- Respuesta: `{"success": "Detalle de préstamo eliminado y stock devuelto"}`

## Validaciones implementadas

1. **Stock suficiente**: Antes de crear o aumentar la cantidad prestada, se verifica que haya stock disponible
2. **Cantidad positiva**: No se permiten cantidades menores o iguales a 0
3. **Rollback automático**: Si falla la operación después de modificar el stock, se revierte el cambio
4. **Existencia del registro**: Se verifica que el detalle de préstamo exista antes de actualizar o eliminar

## Manejo de errores

El sistema maneja diversos tipos de errores:

- **Stock insuficiente**: `{"error": "Stock insuficiente. Disponible: X"}`
- **Libro no encontrado**: `{"error": "Libro no encontrado"}`
- **Detalle no encontrado**: `{"error": "Detalle de préstamo no encontrado"}`
- **Campos requeridos**: `{"error": "Todos los campos son requeridos"}`
- **Cantidad inválida**: `{"error": "La cantidad debe ser mayor a 0"}`
- **Error de base de datos**: `{"error": "Error al reducir stock: [mensaje]"}`

## Flujo recomendado para préstamos

1. **Crear préstamo** en `/view/API/prestamos.php`
2. **Crear detalle(s) de préstamo** en `/view/API/detallePrestamos.php` (automáticamente reduce stock)
3. **Para devolver**: Eliminar los detalles de préstamo (automáticamente devuelve stock)

## Nota importante

Los endpoints y formato JSON **NO han cambiado**. El control de stock es completamente transparente para el cliente de la API. Solo se han agregado validaciones y lógica interna para mantener la consistencia del inventario.
