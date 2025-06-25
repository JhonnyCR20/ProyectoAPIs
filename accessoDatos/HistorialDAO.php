<?php
require_once __DIR__ . '/../misc/Conexion.php';
require_once __DIR__ . '/../models/Historial.php';

class HistorialDAO {
    // Atributo privado para la conexión a la base de datos
    private $pdo;

    // Constructor: Inicializa la conexión a la base de datos
    public function __construct() {
        $this->pdo = Conexion::conectar();
    }

    // Método para obtener todos los registros de historial
    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM grupo6_historial");
        $historiales = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Crea objetos Historial a partir de los datos obtenidos
            $historiales[] = new Historial($row['id_historial'], $row['id_lector'], $row['accion'], $row['fecha']);
        }
        return $historiales;
    }

    // Método para obtener un registro de historial por su ID
    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM Grupo6_historial WHERE id_historial = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row) {
            // Crea un objeto Historial a partir de los datos obtenidos
            return new Historial($row['id_historial'], $row['id_lector'], $row['accion'], $row['fecha']);
        }
        
        return null;
    }

    // Método para insertar un nuevo registro de historial
    public function insert(Historial $historial) {
        $stmt = $this->pdo->prepare("INSERT INTO Grupo6_historial (id_lector, accion, fecha) VALUES (?, ?, ?)");
        return $stmt->execute([$historial->id_lector, $historial->accion, $historial->fecha]);
    }

    // Método para actualizar un registro de historial existente
    public function update(Historial $historial) {
        $stmt = $this->pdo->prepare("UPDATE Grupo6_historial SET id_lector = ?, accion = ?, fecha = ? WHERE id_historial = ?");
        return $stmt->execute([$historial->id_lector, $historial->accion, $historial->fecha, $historial->id_historial]);
    }

    // Método para eliminar un registro de historial por su ID
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM Grupo6_historial WHERE id_historial = ?");
        return $stmt->execute([$id]);
    }
}
?>
