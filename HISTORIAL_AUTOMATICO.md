# Sistema de Historial Automático - Documentación Completa

## 📋 **¿Qué es el Historial Automático?**

El sistema de historial automático registra **todas las acciones importantes** que realizan los lectores en la biblioteca, creando un log detallado de actividades.

## ✅ **¿Dónde se Registra Automáticamente?**

### 🎯 **Módulos con Historial Automático IMPLEMENTADO:**

#### **1. Préstamos (`PrestamoController.php`)**
- ✅ **Crear préstamo**: "Préstamo creado - Estado: activo - Fecha: 2025-06-24"
- ✅ **Actualizar préstamo**: "Préstamo actualizado - ID: 123 - Estado: devuelto"
- ✅ **Eliminar préstamo**: "Préstamo eliminado - ID: 123"

#### **2. Detalles de Préstamo (`DetallePrestamoController.php`)**
- ✅ **Crear detalle**: "Detalle de préstamo creado - Libro: El Quijote - Cantidad: 2"
- ✅ **Control de stock**: Se registra automáticamente cuando se reduce/aumenta stock
- 🔄 **Actualizar/Eliminar**: Pendiente de implementar

#### **3. Reservas (`ReservaController.php`)**
- 🔄 **En proceso**: Configuración agregada, falta implementar métodos

### ⏳ **Módulos PENDIENTES de implementar:**

#### **4. Lectores (`LectorController.php`)**
- 🔄 Registrar cuando se crea/actualiza/elimina un lector

#### **5. Multas (`MultaController.php`)**
- 🔄 Registrar cuando se crea una multa
- 🔄 Registrar cuando se paga una multa

#### **6. Libros (`LibroController.php`)**
- 🔄 Registrar cuando se agrega/actualiza un libro (opcional)

---

## 🚀 **Cómo Funciona el Sistema**

### **Método Principal:**
```php
HistorialController::registrarAccion($idLector, $accion);
```

### **Parámetros:**
- **`$idLector`**: ID del lector que realiza la acción
- **`$accion`**: Descripción textual de la acción realizada

### **Características:**
- ✅ **Automático**: Se ejecuta sin intervención del usuario
- ✅ **No bloquea**: Si falla el registro, no afecta la operación principal
- ✅ **Fecha automática**: Registra timestamp actual
- ✅ **Seguro**: Manejo de errores interno

---

## 📊 **Ejemplos de Registros Automáticos**

### **JSON de Historial Generado:**
```json
[
    {
        "id_historial": 1,
        "id_lector": 5,
        "accion": "Préstamo creado - Estado: activo - Fecha: 2025-06-24",
        "fecha": "2025-06-24 10:30:15"
    },
    {
        "id_historial": 2,
        "id_lector": 5,
        "accion": "Detalle de préstamo creado - Libro: El Quijote - Cantidad: 2",
        "fecha": "2025-06-24 10:31:22"
    },
    {
        "id_historial": 3,
        "id_lector": 3,
        "accion": "Préstamo actualizado - ID: 123 - Estado: devuelto",
        "fecha": "2025-06-24 14:15:33"
    },
    {
        "id_historial": 4,
        "id_lector": 7,
        "accion": "Reserva creada - Libro: Cien años de soledad",
        "fecha": "2025-06-24 16:45:10"
    }
]
```

---

## 🔧 **Flujo de Trabajo Completo**

### **Ejemplo: Crear un Préstamo**
1. **Usuario llama**: `POST /view/API/prestamos.php`
2. **Sistema valida**: Datos requeridos
3. **Sistema crea**: Registro en tabla `prestamos`
4. **Sistema registra**: Automáticamente en `historial`
5. **Respuesta**: `{"success": "Préstamo creado exitosamente"}`

### **Ejemplo: Crear Detalle de Préstamo**
1. **Usuario llama**: `POST /view/API/detallePrestamos.php`
2. **Sistema valida**: Stock disponible
3. **Sistema reduce**: Stock del libro
4. **Sistema crea**: Registro en tabla `detalle_prestamo`
5. **Sistema registra**: Automáticamente en `historial`
6. **Respuesta**: `{"success": "Detalle de préstamo creado exitosamente"}`

---

## 📋 **URLs del Historial (Sin Cambios)**

### **Consultar Historial:**
```http
GET /view/API/historial.php           # Todos los registros
GET /view/API/historial.php/1         # Por ID (REST)
GET /view/API/historial.php?id=1      # Por ID (Query String)
```

### **Crear Registro Manual (Opcional):**
```http
POST /view/API/historial.php
Content-Type: application/json

{
    "id_lector": 5,
    "accion": "Acción manual personalizada"
}
```

---

## 🎯 **Ventajas del Sistema**

### **Para los Administradores:**
- 📊 **Trazabilidad completa** de todas las acciones
- 🔍 **Auditoría** de actividades por lector
- 📈 **Análisis** de patrones de uso
- 🚨 **Detección** de problemas o abusos

### **Para el Sistema:**
- 🔄 **Automático**: No requiere intervención manual
- 🛡️ **Seguro**: No afecta operaciones principales si falla
- 📝 **Completo**: Registra fecha, lector y acción detallada
- 🎨 **Flexible**: Fácil agregar nuevos tipos de registro

---

## ⚡ **Estado Actual del Sistema**

### ✅ **FUNCIONANDO:**
- Historial de préstamos (crear, actualizar, eliminar)
- Historial de detalles de préstamo (crear)
- Control automático de stock con historial
- API de consulta de historial completa

### 🔄 **PRÓXIMOS PASOS:**
- Completar historial en reservas
- Agregar historial en multas
- Agregar historial en lectores
- Historial de cambios en libros (opcional)

¡El sistema está funcionando automáticamente para los módulos más importantes de la biblioteca! 🚀
