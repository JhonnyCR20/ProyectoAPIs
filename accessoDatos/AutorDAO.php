<?php
require_once __DIR__ . '/../misc/Conexion.php';
require_once __DIR__ . '/../models/Autor.php';

class AutorDAO {
    // Atributo privado para la conexión a la base de datos
    private $pdo;

    // Constructor: Inicializa la conexión a la base de datos
    public function __construct() {
        $this->pdo = Conexion::conectar();
    }

    // Método para obtener todos los autores
    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM grupo6_autores");
        $autores = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Crea objetos Autor a partir de los datos obtenidos
            $autores[] = new Autor($row['id_autor'], $row['nombre'], $row['nacionalidad']);
        }
        return $autores;
    }

    // Método para obtener un autor por su ID
    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM grupo6_autores WHERE id_autor = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // Crea un objeto Autor a partir de los datos obtenidos
        return new Autor($row['id_autor'], $row['nombre'], $row['nacionalidad']);
    }

    // Método para insertar un nuevo autor
    public function insert(Autor $autor) {
        $stmt = $this->pdo->prepare("INSERT INTO grupo6_autores (nombre, nacionalidad) VALUES (?, ?)");
        return $stmt->execute([$autor->nombre, $autor->nacionalidad]);
    }

    // Método para actualizar un autor existente
    public function update(Autor $autor) {
        $stmt = $this->pdo->prepare("UPDATE grupo6_autores SET nombre = ?, nacionalidad = ? WHERE id_autor = ?");
        return $stmt->execute([$autor->nombre, $autor->nacionalidad, $autor->id_autor]);
    }

    // Método para eliminar un autor por su ID
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM grupo6_autores WHERE id_autor = ?");
        return $stmt->execute([$id]);
    }
}
?>
