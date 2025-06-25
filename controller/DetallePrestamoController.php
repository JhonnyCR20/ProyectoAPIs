<?php
require_once __DIR__ . '/../accessoDatos/DetallePrestamoDAO.php';
require_once __DIR__ . '/../accessoDatos/LibroDAO.php';
require_once __DIR__ . '/../models/DetallePrestamo.php';
require_once __DIR__ . '/HistorialController.php';

class DetallePrestamoController {
    // Atributos privados para interactuar con la capa de acceso a datos
    private $detallePrestamoDAO;
    private $libroDAO;
    private $prestamoDAO;

    // Constructor: Inicializa las instancias de los DAOs
    public function __construct() {
        $this->detallePrestamoDAO = new DetallePrestamoDAO();
        $this->libroDAO = new LibroDAO();
        // Necesitamos PrestamoDAO para obtener el id_lector del préstamo
        require_once __DIR__ . '/../accessoDatos/PrestamoDAO.php';
        $this->prestamoDAO = new PrestamoDAO();
    }

    // Método para obtener todos los detalles de préstamo
    public function obtenerTodos() {
        $detalles = $this->detallePrestamoDAO->getAll();
        $resultado = [];
        
        // Convertir objetos a arrays para JSON
        foreach ($detalles as $detalle) {
            $resultado[] = [
                'id_detalle' => $detalle->id_detalle,
                'id_prestamo' => $detalle->id_prestamo,
                'id_libro' => $detalle->id_libro,
                'cantidad' => $detalle->cantidad
            ];
        }
        
        return $resultado;
    }

    // Método para obtener un detalle de préstamo por su ID
    public function obtenerPorId($id) {
        $detalle = $this->detallePrestamoDAO->getById($id);
        
        if ($detalle) {
            // Convertir objeto a array para JSON
            return [
                'id_detalle' => $detalle->id_detalle,
                'id_prestamo' => $detalle->id_prestamo,
                'id_libro' => $detalle->id_libro,
                'cantidad' => $detalle->cantidad
            ];
        }
        
        return null;
    }

    // Método para crear un nuevo detalle de préstamo (con control automático de stock)
    public function crear($detalle) {
        try {
            // Validaciones básicas de los datos recibidos
            if (empty($detalle['id_prestamo']) || empty($detalle['id_libro']) || empty($detalle['cantidad'])) {
                return ['error' => 'Todos los campos son requeridos'];
            }
            
            // Validar que la cantidad sea positiva
            if ($detalle['cantidad'] <= 0) {
                return ['error' => 'La cantidad debe ser mayor a 0'];
            }
            
            // Verificar y reducir el stock del libro antes de crear el detalle
            $this->libroDAO->reducirStock($detalle['id_libro'], $detalle['cantidad']);
            
            // Crear objeto DetallePrestamo y insertarlo
            $detalleObj = new DetallePrestamo(null, $detalle['id_prestamo'], $detalle['id_libro'], $detalle['cantidad']);
            $resultado = $this->detallePrestamoDAO->insert($detalleObj);
            
            // Si no se pudo insertar el detalle, devolver el stock
            if (!$resultado) {
                $this->libroDAO->aumentarStock($detalle['id_libro'], $detalle['cantidad']);
                return ['error' => 'No se pudo crear el detalle de préstamo'];
            }
            
            // Registrar en historial
            $prestamo = $this->prestamoDAO->getById($detalle['id_prestamo']);
            if ($prestamo) {
                $libro = $this->libroDAO->getById($detalle['id_libro']);
                $tituloLibro = $libro ? $libro->getTitulo() : "ID: " . $detalle['id_libro'];
                HistorialController::registrarAccion(
                    $prestamo['id_lector'], 
                    "Detalle de préstamo creado - Libro: " . $tituloLibro . " - Cantidad: " . $detalle['cantidad']
                );
            }

            return ['success' => 'Detalle de préstamo creado exitosamente'];
            
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    // Método para actualizar un detalle de préstamo existente (con control automático de stock)
    public function actualizar($detalle) {
        try {
            // Validaciones básicas de los datos recibidos
            if (empty($detalle['id_detalle']) || empty($detalle['id_prestamo']) || empty($detalle['id_libro']) || empty($detalle['cantidad'])) {
                return ['error' => 'Todos los campos son requeridos'];
            }
            
            // Validar que la cantidad sea positiva
            if ($detalle['cantidad'] <= 0) {
                return ['error' => 'La cantidad debe ser mayor a 0'];
            }
            
            // Obtener el detalle actual para comparar cantidades
            $detalleActual = $this->detallePrestamoDAO->getById($detalle['id_detalle']);
            
            if (!$detalleActual) {
                return ['error' => 'Detalle de préstamo no encontrado'];
            }
            
            // Calcular la diferencia en la cantidad
            $diferenciaCantidad = $detalle['cantidad'] - $detalleActual->cantidad;
            
            // Si hay cambio en la cantidad, ajustar el stock
            if ($diferenciaCantidad > 0) {
                // Se aumentó la cantidad prestada, reducir stock adicional
                $this->libroDAO->reducirStock($detalle['id_libro'], $diferenciaCantidad);
            } elseif ($diferenciaCantidad < 0) {
                // Se redujo la cantidad prestada, devolver stock
                $this->libroDAO->aumentarStock($detalle['id_libro'], abs($diferenciaCantidad));
            }
            
            // Crear objeto DetallePrestamo y actualizarlo
            $detalleObj = new DetallePrestamo($detalle['id_detalle'], $detalle['id_prestamo'], $detalle['id_libro'], $detalle['cantidad']);
            $resultado = $this->detallePrestamoDAO->update($detalleObj);
            
            // Si no se pudo actualizar y hubo cambio de stock, revertir
            if (!$resultado && $diferenciaCantidad != 0) {
                if ($diferenciaCantidad > 0) {
                    $this->libroDAO->aumentarStock($detalle['id_libro'], $diferenciaCantidad);
                } else {
                    $this->libroDAO->reducirStock($detalle['id_libro'], abs($diferenciaCantidad));
                }
                return ['error' => 'No se pudo actualizar el detalle de préstamo'];
            }
            
            // Registrar en historial si fue exitoso
            if ($resultado) {
                // Obtener información del préstamo y libro para el historial
                $prestamo = $this->prestamoDAO->getById($detalle['id_prestamo']);
                $libro = $this->libroDAO->getById($detalle['id_libro']);
                $tituloLibro = $libro ? $libro->getTitulo() : 'ID: ' . $detalle['id_libro'];
                
                if ($prestamo) {
                    HistorialController::registrarAccion(
                        $prestamo['id_lector'],
                        "Detalle de préstamo actualizado - Libro: " . $tituloLibro . " - Nueva cantidad: " . $detalle['cantidad']
                    );
                }
            }
            
            return ['success' => 'Detalle de préstamo actualizado exitosamente'];
            
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    // Método para eliminar un detalle de préstamo por su ID (con devolución automática de stock)
    public function eliminar($id) {
        try {
            // Obtener el detalle antes de eliminarlo para devolver el stock
            $detalle = $this->detallePrestamoDAO->getById($id);
            
            if (!$detalle) {
                return ['error' => 'Detalle de préstamo no encontrado'];
            }
            
            // Eliminar el detalle
            $resultado = $this->detallePrestamoDAO->delete($id);
            
            if ($resultado) {
                // Devolver el stock del libro
                $this->libroDAO->aumentarStock($detalle->id_libro, $detalle->cantidad);
                
                // Registrar en historial
                $prestamo = $this->prestamoDAO->getById($detalle->id_prestamo);
                $libro = $this->libroDAO->getById($detalle->id_libro);
                $tituloLibro = $libro ? $libro->getTitulo() : 'ID: ' . $detalle->id_libro;
                
                if ($prestamo) {
                    HistorialController::registrarAccion(
                        $prestamo['id_lector'],
                        "Detalle de préstamo eliminado - Libro: " . $tituloLibro . " - Cantidad devuelta: " . $detalle->cantidad
                    );
                }
                
                return ['success' => 'Detalle de préstamo eliminado y stock devuelto'];
            } else {
                return ['error' => 'No se pudo eliminar el detalle de préstamo'];
            }
            
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
?>
