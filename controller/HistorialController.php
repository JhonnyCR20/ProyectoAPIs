<?php
// Este archivo define la clase HistorialController, que actúa como intermediario entre la capa de acceso a datos (HistorialDAO) y la lógica de negocio.
// Proporciona métodos para realizar operaciones CRUD relacionadas con los registros de historial.

require_once __DIR__ . '/../accessoDatos/HistorialDAO.php';

class HistorialController {
    // Atributo privado para interactuar con la capa de acceso a datos
    private $historialDAO;

    // Constructor: Inicializa la instancia de HistorialDAO
    public function __construct() {
        $this->historialDAO = new HistorialDAO();
    }

    // Método para obtener todos los registros de historial
    public function obtenerTodos() {
        $historiales = $this->historialDAO->getAll();
        $resultado = [];
        
        // Convertir objetos a arrays para JSON
        foreach ($historiales as $historial) {
            $resultado[] = [
                'id_historial' => $historial->id_historial,
                'id_lector' => $historial->id_lector,
                'accion' => $historial->accion,
                'fecha' => $historial->fecha
            ];
        }
        
        return $resultado;
    }

    // Método para obtener un registro de historial por su ID
    public function obtenerPorId($id) {
        $historial = $this->historialDAO->getById($id);
        
        if ($historial && $historial->id_historial) {
            // Convertir objeto a array para JSON
            return [
                'id_historial' => $historial->id_historial,
                'id_lector' => $historial->id_lector,
                'accion' => $historial->accion,
                'fecha' => $historial->fecha
            ];
        }
        
        return null;
    }

    // Método para crear un nuevo registro de historial
    public function crear($data) {
        // Validaciones básicas de los datos recibidos
        if (empty($data['accion'])) {
            return ['error' => 'El campo accion es requerido'];
        }

        // Usar fecha del cliente si se proporciona, sino usar fecha del servidor como fallback
        if (isset($data['fecha_cliente']) && !empty($data['fecha_cliente'])) {
            $fecha = $data['fecha_cliente']; // Prioridad: fecha del cliente
        } elseif (isset($data['fecha']) && !empty($data['fecha'])) {
            $fecha = $data['fecha']; // Segunda opción: fecha manual
        } else {
            $fecha = date('Y-m-d H:i:s'); // Fallback: fecha del servidor
        }

        // Convertir el arreglo en un objeto Historial
        $historial = new Historial(null, $data['id_lector'] ?? null, $data['accion'], $fecha);
        $resultado = $this->historialDAO->insert($historial);
        
        if ($resultado) {
            return ['success' => 'Registro de historial creado exitosamente'];
        } else {
            return ['error' => 'No se pudo crear el registro de historial'];
        }
    }

    // Método para actualizar un registro de historial existente
    public function actualizar($data) {
        // Validaciones básicas de los datos recibidos
        if (empty($data['id_historial']) || empty($data['id_lector']) || empty($data['accion'])) {
            return ['error' => 'Los campos id_historial, id_lector y accion son requeridos'];
        }

        // Si no se proporciona fecha, usar la actual
        $fecha = isset($data['fecha']) ? $data['fecha'] : date('Y-m-d H:i:s');

        // Convertir el arreglo en un objeto Historial
        $historial = new Historial($data['id_historial'], $data['id_lector'], $data['accion'], $fecha);
        $resultado = $this->historialDAO->update($historial);
        
        if ($resultado) {
            return ['success' => 'Registro de historial actualizado exitosamente'];
        } else {
            return ['error' => 'No se pudo actualizar el registro de historial'];
        }
    }

    // Método para eliminar un registro de historial por su ID
    public function eliminar($id) {
        $resultado = $this->historialDAO->delete($id);
        
        if ($resultado) {
            return ['success' => 'Registro de historial eliminado exitosamente'];
        } else {
            return ['error' => 'No se pudo eliminar el registro de historial'];
        }
    }
    
    // Método auxiliar para registrar automáticamente una acción en el historial
    public static function registrarAccion($idLector, $accion, $fechaCliente = null) {
        try {
            $historialDAO = new HistorialDAO();
            
            // Usar fecha del cliente si se proporciona, sino usar fecha del servidor como fallback
            if ($fechaCliente) {
                $fecha = $fechaCliente;
            } else {
                // Para registros automáticos, generar timestamp del cliente usando JavaScript
                // Si no está disponible, usar servidor como fallback
                $fecha = date('Y-m-d H:i:s');
            }
            
            $historial = new Historial(null, $idLector, $accion, $fecha);
            return $historialDAO->insert($historial);
        } catch (Exception $e) {
            // Si falla el registro del historial, no debe afectar la operación principal
            error_log("Error al registrar historial: " . $e->getMessage());
            return false;
        }
    }
}
?>
