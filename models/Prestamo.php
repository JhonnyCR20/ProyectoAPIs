<?php
// Este archivo define la clase Prestamo, que representa los préstamos en el sistema.
// Contiene atributos como id_prestamo, id_lector, fecha de préstamo, fecha de devolución y estado.

class Prestamo {
    public $id_prestamo;
    public $id_lector;
    public $fecha_prestamo;
    public $fecha_devolucion;
    public $estado;

    // Constructor: Inicializa los atributos de la clase Prestamo
    public function __construct($id_prestamo, $id_lector, $fecha_prestamo, $fecha_devolucion, $estado) {
        $this->id_prestamo = $id_prestamo;
        $this->id_lector = $id_lector;
        $this->fecha_prestamo = $fecha_prestamo;
        $this->fecha_devolucion = $fecha_devolucion;
        $this->estado = $estado;
    }
}
?>
