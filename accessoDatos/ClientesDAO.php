<?php

require_once __DIR__.'/../misc/Conexion.php';
require_once __DIR__.'/../models/Clientes.php';

class ClientesDAO{

    // Atributo privado para la conexión a la base de datos
    private $pdo;

    // Constructor: Inicializa la conexión a la base de datos
    public function __construct(){
        $this->pdo = Conexion::conectar();
    }

    // Método para obtener todos los clientes
    public function obtenerDatos(){
        $stmt = $this->pdo->query("Select * from clientes");

        $result = [];

        while ($row = $stmt->fetch((PDO::FETCH_ASSOC))){
            // Crea objetos Clientes a partir de los datos obtenidos
            $result[] = new Clientes($row['id'], $row['nombre'], $row['apellidos'], $row['telefono']);
        }

        return $result;
    }

    // Método para obtener un cliente por su ID
    public function obtenerPorId($id){
        $stmt = $this->pdo->prepare("SELECT * FROM u484426513_ms225.clientes WHERE id = ?;");
        $stmt->execute([$id]);
        
        $row = $stmt->fetch((PDO::FETCH_ASSOC));
        // Crea un objeto Clientes a partir de los datos obtenidos
        return new Clientes($row['id'], $row['nombre'], $row['apellidos'], $row['telefono']);
    }

    // Método para insertar un nuevo cliente
    public function insertar( Clientes $objeto){
        $sql = "INSERT INTO u484426513_ms225.clientes(nombre, apellidos, telefono) VALUES (?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$objeto->nombre, $objeto->apellidos, $objeto->telefono]);
    }
}

?>