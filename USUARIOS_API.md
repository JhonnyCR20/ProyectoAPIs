# API Usuarios - Documentación Completa

## 📋 **Endpoints Disponibles**

### **Base URL:** `/ProyectoApi/ProyectoAPIs/view/API/usuarios.php`

---

## 🔍 **GET - Obtener Usuarios**

### **1. Obtener todos los usuarios**
```http
GET /ProyectoApi/ProyectoAPIs/view/API/usuarios.php
```

**Respuesta exitosa:**
```json
{
    "status": "success",
    "data": [
        {
            "id_usuario": 1,
            "nombre": "Juan Pérez",
            "correo": "juan@email.com",
            "rol": "admin"
        },
        {
            "id_usuario": 2,
            "nombre": "María García",
            "correo": "maria@email.com",
            "rol": "bibliotecario"
        }
    ]
}
```

### **2. Obtener usuario específico (URL Path)**
```http
GET /ProyectoApi/ProyectoAPIs/view/API/usuarios.php/1
```

### **3. Obtener usuario específico (Query String)**
```http
GET /ProyectoApi/ProyectoAPIs/view/API/usuarios.php?id=1
```

**Respuesta exitosa:**
```json
{
    "status": "success",
    "data": {
        "id_usuario": 1,
        "nombre": "Juan Pérez",
        "correo": "juan@email.com",
        "rol": "admin"
    }
}
```

**Respuesta error (usuario no encontrado):**
```json
{
    "status": "error",
    "message": "Usuario no encontrado"
}
```

---

## ➕ **POST - Crear Usuario**

### **Crear nuevo usuario**
```http
POST /ProyectoApi/ProyectoAPIs/view/API/usuarios.php
Content-Type: application/json

{
    "nombre": "Carlos López",
    "correo": "carlos@email.com",
    "clave": "password123",
    "rol": "bibliotecario"
}
```

**Campos requeridos:**
- `nombre` (string) - Nombre completo del usuario
- `correo` (string) - Email válido del usuario
- `clave` (string) - Contraseña del usuario
- `rol` (string) - Rol del usuario: `"admin"` o `"bibliotecario"`

**Respuesta exitosa:**
```json
{
    "status": "success",
    "message": "Usuario creado",
    "id": 3
}
```

**Respuesta error:**
```json
{
    "status": "error",
    "message": "Correo electrónico no válido"
}
```

**Historial automático registrado:**
```
"Usuario creado - Nombre: Carlos López - Rol: bibliotecario - Correo: carlos@email.com"
```

---

## 🔐 **POST - Login de Usuario**

### **Autenticar usuario**
```http
POST /ProyectoApi/ProyectoAPIs/view/API/usuarios.php/login
Content-Type: application/json

{
    "correo": "juan@email.com",
    "clave": "password123"
}
```

**Respuesta exitosa:**
```json
{
    "status": "success",
    "data": {
        "success": true,
        "usuario": {
            "id_usuario": 1,
            "nombre": "Juan Pérez",
            "correo": "juan@email.com",
            "rol": "admin"
        }
    }
}
```

**Respuesta error:**
```json
{
    "status": "error",
    "message": "Credenciales inválidas"
}
```

---

## ✏️ **PUT - Actualizar Usuario**

### **Actualizar usuario existente (URL Path)**
```http
PUT /ProyectoApi/ProyectoAPIs/view/API/usuarios.php/1
Content-Type: application/json

{
    "nombre": "Juan Carlos Pérez",
    "correo": "juancarlos@email.com",
    "clave": "newpassword123",
    "rol": "admin"
}
```

### **Actualizar usuario existente (Query String)**
```http
PUT /ProyectoApi/ProyectoAPIs/view/API/usuarios.php?id=1
Content-Type: application/json

{
    "nombre": "Juan Carlos Pérez",
    "correo": "juancarlos@email.com"
}
```

**Campos opcionales:**
- `clave` - Solo se actualiza si se proporciona
- `rol` - Solo se actualiza si se proporciona

**Respuesta exitosa:**
```json
{
    "status": "success",
    "data": {
        "success": "Usuario actualizado exitosamente"
    }
}
```

**Historial automático registrado:**
```
"Usuario actualizado - ID: 1 - Nombre: Juan Carlos Pérez"
```

---

## 🗑️ **DELETE - Eliminar Usuario**

### **Eliminar usuario (URL Path)**
```http
DELETE /ProyectoApi/ProyectoAPIs/view/API/usuarios.php/1
```

### **Eliminar usuario (Query String)**
```http
DELETE /ProyectoApi/ProyectoAPIs/view/API/usuarios.php?id=1
```

**Respuesta exitosa:**
```json
{
    "status": "success",
    "data": {
        "status": "success",
        "message": "Usuario eliminado correctamente"
    }
}
```

**Respuesta error:**
```json
{
    "status": "error",
    "message": "ID requerido para eliminar"
}
```

**Historial automático registrado:**
```
"Usuario eliminado - ID: 1 - Nombre: Juan Pérez"
```

---

## 🔄 **Manejo de IDs - Compatibilidad Dual**

### ✅ **Ambos formatos soportados:**

1. **URL Path Style:** `/usuarios.php/123`
2. **Query String Style:** `/usuarios.php?id=123`

### **Prioridad:**
1. **Primero** se busca ID en la URL path
2. **Segundo** se busca ID en query string
3. **Si no hay ID** se asume operación sobre todos los registros

---

## 🎯 **Validaciones**

### **Crear Usuario:**
- ✅ Todos los campos son requeridos
- ✅ Email debe ser válido
- ✅ Rol debe ser 'admin' o 'bibliotecario'

### **Actualizar Usuario:**
- ✅ ID es requerido
- ✅ Nombre y correo son requeridos
- ✅ Clave y rol son opcionales

### **Eliminar Usuario:**
- ✅ ID es requerido
- ✅ ID debe ser numérico
- ✅ Usuario debe existir

---

## 📊 **Historial Automático**

### **✅ Operaciones registradas:**
- **Crear:** Incluye nombre, rol y correo
- **Actualizar:** Incluye ID y nuevo nombre
- **Eliminar:** Incluye ID y nombre del usuario eliminado

### **🔍 Ver historial de usuarios:**
```http
GET /ProyectoApi/ProyectoAPIs/view/API/historial.php
```

---

## 🚀 **Ejemplos de Uso con JavaScript**

### **Crear usuario:**
```javascript
const response = await fetch('/ProyectoApi/ProyectoAPIs/view/API/usuarios.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
        nombre: 'Ana Martínez',
        correo: 'ana@email.com',
        clave: 'password123',
        rol: 'bibliotecario'
    })
});
const result = await response.json();
```

### **Obtener usuario por ID:**
```javascript
// Opción 1: URL Path
const response1 = await fetch('/ProyectoApi/ProyectoAPIs/view/API/usuarios.php/1');

// Opción 2: Query String  
const response2 = await fetch('/ProyectoApi/ProyectoAPIs/view/API/usuarios.php?id=1');
```

### **Login:**
```javascript
const response = await fetch('/ProyectoApi/ProyectoAPIs/view/API/usuarios.php/login', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
        correo: 'admin@email.com',
        clave: 'password123'
    })
});
```

---

## ⚠️ **Códigos de Respuesta HTTP**

- **200** - Operación exitosa
- **201** - Usuario creado exitosamente
- **400** - Error en los datos enviados
- **401** - Error de autenticación (login)
- **404** - Usuario no encontrado
- **405** - Método HTTP no permitido
- **500** - Error interno del servidor
