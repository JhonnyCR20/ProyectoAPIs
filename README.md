# Proyecto API

Este proyecto es una API desarrollada en PHP que permite gestionar una biblioteca, incluyendo usuarios, lectores, libros, préstamos y más.

## Requisitos Previos

Asegúrate de tener instalados los siguientes componentes antes de comenzar:

- **PHP** >= 7.4
- **MySQL** o cualquier base de datos compatible
- **XAMPP** (opcional, para un entorno local)

## Instalación

Sigue estos pasos para instalar y configurar el proyecto:

1. Clona este repositorio:
   ```bash
   git clone https://github.com/JhonnyCR20/ProyectoAPIs
   cd ProyectoApi
   ```

2. Configura el archivo de conexión a la base de datos en `misc/Conexion.php`:
   - Edita las credenciales de conexión a la base de datos según tu entorno:
     ```php
     define('DB_HOST', '127.0.0.1');
     define('DB_USER', 'usuario');
     define('DB_PASSWORD', 'contraseña');
     define('DB_NAME', 'nombre_base_datos');
     ```

3. Asegúrate de que el servidor Apache y MySQL estén activos si usas XAMPP.

4. Importa el archivo SQL con la estructura de la base de datos (si está disponible).

## Ejecución

Para iniciar el servidor local, coloca el proyecto en el directorio `htdocs` de XAMPP y accede a la URL:

```
http://localhost/ProyectoApi
```

## Endpoints Disponibles

Los endpoints de la API están organizados por recursos. A continuación, se listan los principales:

### Usuarios
- **GET** `/view/API/usuarios.php` - Obtener todos los usuarios
- **POST** `/view/API/usuarios.php` - Crear nuevo usuario
- **PUT** `/view/API/usuarios.php` - Actualizar usuario
- **DELETE** `/view/API/usuarios.php` - Eliminar usuario

### Lectores
- **GET** `/view/API/lectores.php` - Obtener todos los lectores
- **POST** `/view/API/lectores.php` - Crear nuevo lector
- **PUT** `/view/API/lectores.php` - Actualizar lector
- **DELETE** `/view/API/lectores.php` - Eliminar lector

### Libros
- **GET** `/view/API/libros.php` - Obtener todos los libros
- **POST** `/view/API/libros.php` - Crear nuevo libro
- **PUT** `/view/API/libros.php` - Actualizar libro
- **DELETE** `/view/API/libros.php` - Eliminar libro

### Préstamos
- **GET** `/view/API/prestamos.php` - Obtener todos los préstamos
- **POST** `/view/API/prestamos.php` - Crear nuevo préstamo
- **PUT** `/view/API/prestamos.php` - Actualizar préstamo
- **DELETE** `/view/API/prestamos.php` - Eliminar préstamo

## Ejemplos de Uso

### Crear un nuevo lector
```http
POST /view/API/lectores.php
Content-Type: application/json

{
    "nombre": "Juan Pérez",
    "correo": "juan@email.com",
    "telefono": "123456789",
    "direccion": "Calle Principal 123"
}
```

### Obtener un libro por ID
```http
GET /view/API/libros.php?id=1
```

### Actualizar un préstamo
```http
PUT /view/API/prestamos.php
Content-Type: application/json

{
    "id": 1,
    "estado": "devuelto",
    "fecha_devolucion": "2025-06-15"
}
```

## Notas Adicionales

- Asegúrate de que los permisos de los archivos y carpetas sean correctos para evitar problemas de acceso.
- Puedes usar herramientas como Postman para probar los endpoints de la API.

## Licencia

Este proyecto está bajo la licencia [MIT](LICENSE).
