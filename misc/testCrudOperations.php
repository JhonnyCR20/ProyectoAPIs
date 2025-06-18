<?php
require_once __DIR__ . '/../accessoDatos/UsuarioDAO.php';
require_once __DIR__ . '/../accessoDatos/AutorDAO.php';
require_once __DIR__ . '/../accessoDatos/EditorialDAO.php';
require_once __DIR__ . '/../accessoDatos/CategoriaDAO.php';

// Función para probar las operaciones CRUD de UsuarioDAO
function testUsuarioDAO() {
    $dao = new UsuarioDAO(); // Instancia de UsuarioDAO

    // Crear un nuevo usuario
    $newUser = [
        'nombre' => 'Test User',
        'correo' => 'testuser@example.com',
        'clave' => 'password123',
        'rol' => 'user'
    ];
    $userId = $dao->crear($newUser);
    echo "Usuario creado con ID: $userId\n";

    // Actualizar el usuario creado
    $updatedUser = [
        'nombre' => 'Updated User',
        'correo' => 'updateduser@example.com'
    ];
    $result = $dao->actualizar($userId, $updatedUser);
    echo "Usuario actualizado: " . ($result ? 'Éxito' : 'Fallo') . "\n";

    // Eliminar el usuario creado
    $result = $dao->eliminar($userId);
    echo "Usuario eliminado: " . ($result ? 'Éxito' : 'Fallo') . "\n";
}

// Función para probar las operaciones CRUD de AutorDAO
function testAutorDAO() {
    $dao = new AutorDAO(); // Instancia de AutorDAO

    // Crear un nuevo autor
    $newAutor = new Autor(null, 'Test Autor', 'Test Nacionalidad');
    $result = $dao->insert($newAutor);
    echo "Autor creado: " . ($result ? 'Éxito' : 'Fallo') . "\n";

    // Actualizar el autor creado
    $newAutor->setNombre('Updated Autor');
    $newAutor->setNacionalidad('Updated Nacionalidad');
    $result = $dao->update($newAutor);
    echo "Autor actualizado: " . ($result ? 'Éxito' : 'Fallo') . "\n";

    // Eliminar el autor creado
    $result = $dao->delete($newAutor->getIdAutor());
    echo "Autor eliminado: " . ($result ? 'Éxito' : 'Fallo') . "\n";
}

// Función para probar las operaciones CRUD de EditorialDAO
function testEditorialDAO() {
    $dao = new EditorialDAO(); // Instancia de EditorialDAO

    // Crear una nueva editorial
    $newEditorial = new Editorial(null, 'Test Editorial', 'Test País');
    $result = $dao->insert($newEditorial);
    echo "Editorial creada: " . ($result ? 'Éxito' : 'Fallo') . "\n";

    // Actualizar la editorial creada
    $newEditorial->setNombre('Updated Editorial');
    $newEditorial->setPais('Updated País');
    $result = $dao->update($newEditorial);
    echo "Editorial actualizada: " . ($result ? 'Éxito' : 'Fallo') . "\n";

    // Eliminar la editorial creada
    $result = $dao->delete($newEditorial->getIdEditorial());
    echo "Editorial eliminada: " . ($result ? 'Éxito' : 'Fallo') . "\n";
}

// Función para probar las operaciones CRUD de CategoriaDAO
function testCategoriaDAO() {
    $dao = new CategoriaDAO(); // Instancia de CategoriaDAO

    // Crear una nueva categoría
    $newCategoria = new Categoria(null, 'Test Categoria', 'Test Descripción');
    $result = $dao->insert($newCategoria);
    echo "Categoría creada: " . ($result ? 'Éxito' : 'Fallo') . "\n";

    // Actualizar la categoría creada
    $newCategoria->setNombre('Updated Categoria');
    $newCategoria->setDescripcion('Updated Descripción');
    $result = $dao->update($newCategoria);
    echo "Categoría actualizada: " . ($result ? 'Éxito' : 'Fallo') . "\n";

    // Eliminar la categoría creada
    $result = $dao->delete($newCategoria->getIdCategoria());
    echo "Categoría eliminada: " . ($result ? 'Éxito' : 'Fallo') . "\n";
}

// Ejecutar pruebas
echo "Pruebas para UsuarioDAO:\n";
testUsuarioDAO();

echo "\nPruebas para AutorDAO:\n";
testAutorDAO();

echo "\nPruebas para EditorialDAO:\n";
testEditorialDAO();

echo "\nPruebas para CategoriaDAO:\n";
testCategoriaDAO();
?>
