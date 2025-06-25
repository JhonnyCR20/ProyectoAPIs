<?php
require_once __DIR__ . '/../accessoDatos/LectorDAO.php';
require_once __DIR__ . '/HistorialController.php';

class LectorApiController {
    // Atributo privado para interactuar con la capa de acceso a datos
    private $lectorDAO;

    // Constructor: Inicializa la instancia de LectorDAO
    public function __construct() {
        $this->lectorDAO = new LectorDAO();
    }

    // Método para procesar las solicitudes HTTP
    public function procesarPeticion($metodo, $id = null) {
        header('Content-Type: application/json'); // Configura el encabezado de respuesta
        
        try {
            switch ($metodo) {
                case 'GET':
                    if ($id) {
                        // Obtiene un lector por su ID
                        $lector = $this->lectorDAO->getById($id);
                        if ($lector) {
                            echo json_encode(['status' => 'success', 'data' => $lector->toArray()]);
                        } else {
                            http_response_code(404);
                            echo json_encode(['status' => 'error', 'message' => 'Lector no encontrado']);
                        }
                    } else {
                        // Obtiene todos los lectores
                        $lectores = $this->lectorDAO->getAll();
                        echo json_encode(['status' => 'success', 'data' => array_map(function($lector) {
                            return $lector->toArray();
                        }, $lectores)]);
                    }
                    break;

                case 'POST':
                    // Crea un nuevo lector
                    $input = file_get_contents('php://input');
                    $datos = json_decode($input, true);

                    if (json_last_error() !== JSON_ERROR_NONE) {
                        http_response_code(400);
                        echo json_encode(['status' => 'error', 'message' => 'JSON inválido', 'error' => json_last_error_msg()]);
                        return;
                    }

                    if (!isset($datos['nombre'], $datos['correo'], $datos['telefono'], $datos['direccion'])) {
                        http_response_code(400);
                        echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']);
                        return;
                    }
                    error_log("Correo recibido: " . $datos['correo']);
                    error_log("Datos recibidos en el controlador: " . json_encode($datos));
                    $lector = new Lector();
                    $lector->setNombre($datos['nombre']);
                    $lector->setCorreo($datos['correo']);
                    $lector->setTelefono($datos['telefono']);
                    $lector->setDireccion($datos['direccion']);
                    
                    $id = $this->lectorDAO->create($lector);
                    
                    // Registrar en historial
                    if ($id) {
                        HistorialController::registrarAccion(
                            $id, 
                            "Perfil de lector creado - Nombre: " . $datos['nombre']
                        );
                    }
                    
                    http_response_code(201);
                    echo json_encode(['status' => 'success', 'message' => 'Lector creado', 'id' => $id]);
                    break;

                case 'PUT':
                    if (!$id) {
                        http_response_code(400);
                        echo json_encode(['status' => 'error', 'message' => 'Se requiere ID']);
                        break;
                    }
                    // Actualiza un lector existente
                    $datos = json_decode(file_get_contents('php://input'), true);
                    $lector = new Lector();
                    $lector->setId($id);
                    $lector->setNombre(isset($datos['nombre']) ? $datos['nombre'] : '');
                    $lector->setCorreo(isset($datos['correo']) ? $datos['correo'] : '');
                    $lector->setTelefono(isset($datos['telefono']) ? $datos['telefono'] : '');
                    $lector->setDireccion(isset($datos['direccion']) ? $datos['direccion'] : '');
                    
                    $resultado = $this->lectorDAO->update($lector);
                    
                    // Registrar en historial
                    if ($resultado) {
                        HistorialController::registrarAccion(
                            $id, 
                            "Perfil de lector actualizado - Nombre: " . $datos['nombre']
                        );
                    }
                    
                    echo json_encode(['status' => 'success', 'message' => 'Lector actualizado']);
                    break;

                case 'DELETE':
                    if (!$id) {
                        http_response_code(400);
                        echo json_encode(['status' => 'error', 'message' => 'Se requiere ID']);
                        break;
                    }
                    // Elimina un lector por su ID
                    $resultado = $this->lectorDAO->delete($id);
                    
                    // Registrar en historial
                    if ($resultado) {
                        HistorialController::registrarAccion(
                            $id, 
                            "Perfil de lector eliminado - ID: " . $id
                        );
                    }
                    
                    echo json_encode(['status' => 'success', 'message' => 'Lector eliminado']);
                    break;

                default:
                    http_response_code(405);
                    echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
                    break;
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
?>
