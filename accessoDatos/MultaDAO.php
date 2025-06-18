<?php
require_once __DIR__ . '/../misc/Conexion.php';
require_once __DIR__ . '/../models/Multa.php';

class MultaDAO {
    // Atributo privado para la conexión a la base de datos
    private $pdo;

    // Constructor: Inicializa la conexión a la base de datos
    public function __construct() {
        $this->pdo = Conexion::conectar();
    }

    // Método para obtener todas las multas
    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM grupo6_multas");
        $multas = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Crea objetos Multa a partir de los datos obtenidos
            $multas[] = new Multa($row['id_multa'], $row['id_prestamo'], $row['monto'], $row['pagado']);
        }
        return $multas;
    }

    // Método para obtener una multa por su ID
    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM grupo6_multas WHERE id_multa = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // Crea un objeto Multa a partir de los datos obtenidos
        return new Multa($row['id_multa'], $row['id_prestamo'], $row['monto'], $row['pagado']);
    }

    // Método para insertar una nueva multa
    public function insert(Multa $multa) {
        $stmt = $this->pdo->prepare("INSERT INTO grupo6_multas (id_prestamo, monto, pagado) VALUES (?, ?, ?)");
        return $stmt->execute([$multa->id_prestamo, $multa->monto, $multa->pagado]);
    }

    // Método para actualizar una multa existente
    public function update(Multa $multa) {
        $stmt = $this->pdo->prepare("UPDATE grupo6_multas SET id_prestamo = ?, monto = ?, pagado = ? WHERE id_multa = ?");
        return $stmt->execute([$multa->id_prestamo, $multa->monto, $multa->pagado, $multa->id_multa]);
    }

    // Método para eliminar una multa por su ID
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM grupo6_multas WHERE id_multa = ?");
        return $stmt->execute([$id]);
    }
}
?>
