<?php
require_once __DIR__ . '/../misc/Conexion.php';
require_once __DIR__ . '/../models/Editorial.php';

class EditorialDAO {
    // Atributo privado para la conexión a la base de datos
    private $pdo;

    // Constructor: Inicializa la conexión a la base de datos
    public function __construct() {
        $this->pdo = Conexion::conectar();
    }

    // Método para obtener todas las editoriales
    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM grupo6_editoriales");
        $editoriales = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Crea objetos Editorial a partir de los datos obtenidos
            $editoriales[] = new Editorial($row['id_editorial'], $row['nombre'], $row['pais']);
        }
        return $editoriales;
    }

    // Método para obtener una editorial por su ID
    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM grupo6_editoriales WHERE id_editorial = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // Crea un objeto Editorial a partir de los datos obtenidos
        return new Editorial($row['id_editorial'], $row['nombre'], $row['pais']);
    }

    // Método para insertar una nueva editorial
    public function insert(Editorial $editorial) {
        $stmt = $this->pdo->prepare("INSERT INTO grupo6_editoriales (nombre, pais) VALUES (?, ?)");
        return $stmt->execute([$editorial->nombre, $editorial->pais]);
    }

    // Método para actualizar una editorial existente
    public function update(Editorial $editorial) {
        $stmt = $this->pdo->prepare("UPDATE grupo6_editoriales SET nombre = ?, pais = ? WHERE id_editorial = ?");
        return $stmt->execute([$editorial->nombre, $editorial->pais, $editorial->id_editorial]);
    }

    // Método para eliminar una editorial por su ID
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM grupo6_editoriales WHERE id_editorial = ?");
        return $stmt->execute([$id]);
    }
}
?>
