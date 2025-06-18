<?php
require_once __DIR__ . '/../misc/Conexion.php';
require_once __DIR__ . '/../models/Reserva.php';

class ReservaDAO {
    // Atributo privado para la conexión a la base de datos
    private $pdo;

    // Constructor: Inicializa la conexión a la base de datos
    public function __construct() {
        $this->pdo = Conexion::conectar();
    }

    // Método para obtener todas las reservas
    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM grupo6_reservas");
        $reservas = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Crea objetos Reserva a partir de los datos obtenidos
            $reservas[] = new Reserva($row['id_reserva'], $row['id_lector'], $row['id_libro'], $row['fecha_reserva'], $row['estado']);
        }
        return $reservas;
    }

    // Método para obtener una reserva por su ID
    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM grupo6_reservas WHERE id_reserva = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null; // Retornar null si no hay resultados
        }

        // Crea un objeto Reserva a partir de los datos obtenidos
        return new Reserva($row['id_reserva'], $row['id_lector'], $row['id_libro'], $row['fecha_reserva'], $row['estado']);
    }

    // Método para insertar una nueva reserva
    public function insert(Reserva $reserva) {
        $stmt = $this->pdo->prepare("INSERT INTO grupo6_reservas (id_lector, id_libro, fecha_reserva, estado) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$reserva->id_lector, $reserva->id_libro, $reserva->fecha_reserva, $reserva->estado]);
    }

    // Método para actualizar una reserva existente
    public function update(Reserva $reserva) {
        $stmt = $this->pdo->prepare("UPDATE grupo6_reservas SET id_lector = ?, id_libro = ?, fecha_reserva = ?, estado = ? WHERE id_reserva = ?");
        return $stmt->execute([$reserva->id_lector, $reserva->id_libro, $reserva->fecha_reserva, $reserva->estado, $reserva->id_reserva]);
    }

    // Método para eliminar una reserva por su ID
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM grupo6_reservas WHERE id_reserva = ?");
        return $stmt->execute([$id]);
    }
}
?>
