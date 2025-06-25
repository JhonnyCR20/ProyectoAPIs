<?php
// Este archivo define la clase MultaController, que actúa como intermediario entre la capa de acceso a datos (MultaDAO) y la lógica de negocio.
// Proporciona métodos para realizar operaciones CRUD relacionadas con las multas.

require_once __DIR__ . '/../accessoDatos/MultaDAO.php';
require_once __DIR__ . '/HistorialController.php';

class MultaController {
    private $multaDAO;

    // Constructor: Inicializa la instancia de MultaDAO
    public function __construct() {
        $this->multaDAO = new MultaDAO();
    }

    // Método para obtener todas las multas
    public function obtenerTodos() {
        // Llama al método getAll() de MultaDAO para recuperar todas las multas
        return $this->multaDAO->getAll();
    }

    // Método para obtener una multa por su ID
    public function obtenerPorId($id) {
        // Llama al método getById() de MultaDAO para recuperar una multa específica
        return $this->multaDAO->getById($id);
    }

    // Método para crear una nueva multa
    public function crear($data) {
        // Validaciones básicas de los datos recibidos
        if (empty($data['id_prestamo']) || empty($data['monto']) || !isset($data['pagado'])) {
            return ['error' => 'Todos los campos son requeridos'];
        }

        // Convertir el arreglo en un objeto Multa
        $multa = new Multa(null, $data['id_prestamo'], $data['monto'], $data['pagado']);
        $resultado = $this->multaDAO->insert($multa);
        
        // Registrar en historial si fue exitoso
        if ($resultado) {
            // Obtener id_lector del préstamo
            require_once __DIR__ . '/../accessoDatos/PrestamoDAO.php';
            $prestamoDAO = new PrestamoDAO();
            $prestamo = $prestamoDAO->getById($data['id_prestamo']);
            
            if ($prestamo) {
                $estadoPago = $data['pagado'] ? 'pagada' : 'pendiente';
                HistorialController::registrarAccion(
                    $prestamo['id_lector'], 
                    "Multa creada - Monto: $" . $data['monto'] . " - Estado: " . $estadoPago
                );
            }
            return ['success' => 'Multa creada exitosamente'];
        } else {
            return ['error' => 'No se pudo crear la multa'];
        }
    }

    // Método para actualizar una multa existente
    public function actualizar($data) {
        // Validaciones básicas de los datos recibidos
        if (empty($data['id_multa']) || empty($data['id_prestamo']) || empty($data['monto']) || !isset($data['pagado'])) {
            return ['error' => 'Todos los campos son requeridos'];
        }

        // Convertir el arreglo en un objeto Multa
        $multa = new Multa($data['id_multa'], $data['id_prestamo'], $data['monto'], $data['pagado']);
        $resultado = $this->multaDAO->update($multa);
        
        // Registrar en historial si fue exitoso
        if ($resultado) {
            // Obtener id_lector del préstamo
            require_once __DIR__ . '/../accessoDatos/PrestamoDAO.php';
            $prestamoDAO = new PrestamoDAO();
            $prestamo = $prestamoDAO->getById($data['id_prestamo']);
            
            if ($prestamo) {
                $estadoPago = $data['pagado'] ? 'pagada' : 'pendiente';
                HistorialController::registrarAccion(
                    $prestamo['id_lector'], 
                    "Multa actualizada - ID: " . $data['id_multa'] . " - Estado: " . $estadoPago . " - Monto: $" . $data['monto']
                );
            }
            return ['success' => 'Multa actualizada exitosamente'];
        } else {
            return ['error' => 'No se pudo actualizar la multa'];
        }
    }

    // Método para eliminar una multa por su ID
    public function eliminar($id) {
        // Obtener información de la multa antes de eliminarla
        $multa = $this->multaDAO->getById($id);
        
        // Eliminar la multa
        $resultado = $this->multaDAO->delete($id);
        
        // Registrar en historial si fue exitoso
        if ($resultado && $multa) {
            // Obtener id_lector del préstamo
            require_once __DIR__ . '/../accessoDatos/PrestamoDAO.php';
            $prestamoDAO = new PrestamoDAO();
            $prestamo = $prestamoDAO->getById($multa['id_prestamo']);
            
            if ($prestamo) {
                HistorialController::registrarAccion(
                    $prestamo['id_lector'], 
                    "Multa eliminada - ID: " . $id . " - Monto: $" . $multa['monto']
                );
            }
            return ['success' => 'Multa eliminada exitosamente'];
        } else {
            return ['error' => 'No se pudo eliminar la multa'];
        }
    }
}
?>
