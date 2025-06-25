<?php

require_once __DIR__.'/../accessoDatos/ClientesDAO.php';
require_once __DIR__ . '/HistorialController.php';

class ClientesController{
    // Atributo privado para interactuar con la capa de acceso a datos
    private $dao;

    // Constructor: Inicializa la instancia de ClientesDAO
    public function __construct(){
        $this->dao = new ClientesDAO();
    }

    // Método para obtener todos los clientes
    public function obtenerDatos(){
        return $this->dao->obtenerDatos();
    }

    // Método para obtener un cliente por su ID
    public function obtenerPorId($id){
        return $this->dao->obtenerPorId($id);
    }

    // Método para insertar un nuevo cliente
    public function insertar(Clientes $objeto){
        $resultado = $this->dao->insertar($objeto);
        
        // Registrar en historial si fue exitoso
        if ($resultado) {
            HistorialController::registrarAccion(
                null, // No hay lector específico para clientes
                "Cliente creado - Nombre: " . $objeto->nombre . " " . $objeto->apellidos . " - Teléfono: " . $objeto->telefono
            );
        }
        
        return $resultado;
    }
}

// Manejo de solicitudes POST para insertar un cliente
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    // Obtiene los datos enviados desde el formulario
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $telefono = $_POST['telefono'];

    // Crea un objeto Clientes con los datos recibidos
    $objeto = new Clientes(null, $nombre, $apellidos, $telefono);

    // Instancia el controlador y llama al método insertar
    $controlador = new ClientesController();
    $controlador->insertar($objeto);

    // Redirige a la vista de clientes
    header("Location: ../view/Clientes");
    exit();
}
?>