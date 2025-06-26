<?php
require_once __DIR__ . '/../misc/Conexion.php';
require_once __DIR__ . '/../models/Categoria.php';

class CategoriaDAO {
    // Atributo privado para la conexión a la base de datos
    private $pdo;

    // Constructor: Inicializa la conexión a la base de datos
    public function __construct() {
        $this->pdo = Conexion::conectar();
    }

    // Método para obtener todas las categorías
    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM grupo6_categorias");
        $categorias = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Crea objetos Categoria a partir de los datos obtenidos
            $categorias[] = new Categoria($row['id_categoria'], $row['nombre'], $row['descripcion']);
        }
        return $categorias;
    }

    // Método para obtener una categoría por su ID
    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM grupo6_categorias WHERE id_categoria = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // Crea un objeto Categoria a partir de los datos obtenidos
        return new Categoria($row['id_categoria'], $row['nombre'], $row['descripcion']);
    }

    // Método para insertar una nueva categoría
    public function insert(Categoria $categoria) {
        $stmt = $this->pdo->prepare("INSERT INTO grupo6_categorias (nombre, descripcion) VALUES (?, ?)");
        return $stmt->execute([$categoria->nombre, $categoria->descripcion]);
    }

    // Método para actualizar una categoría existente
    public function update(Categoria $categoria) {
        $stmt = $this->pdo->prepare("UPDATE grupo6_categorias SET nombre = ?, descripcion = ? WHERE id_categoria = ?");
        return $stmt->execute([$categoria->nombre, $categoria->descripcion, $categoria->id_categoria]);
    }

    // Método para eliminar una categoría por su ID
    public function delete($id) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM grupo6_categorias WHERE id_categoria = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            // Error 1451: Cannot delete or update a parent row: a foreign key constraint fails
            if ($e->getCode() == '23000' || strpos($e->getMessage(), '1451') !== false) {
                return ['error' => 'foreign_key', 'message' => 'No se puede eliminar la categoría porque está siendo utilizada por uno o más libros'];
            }
            return false;
        }
    }
}
?>
