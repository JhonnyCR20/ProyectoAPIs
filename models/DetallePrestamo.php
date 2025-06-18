<?php
// Este archivo define la clase DetallePrestamo, que representa los detalles de los préstamos en el sistema.
// Contiene atributos como id_detalle, id_prestamo, id_libro y cantidad.

class DetallePrestamo {
    public $id_detalle;
    public $id_prestamo;
    public $id_libro;
    public $cantidad;

    // Constructor: Inicializa los atributos de la clase DetallePrestamo
    public function __construct($id_detalle, $id_prestamo, $id_libro, $cantidad) {
        $this->id_detalle = $id_detalle;
        $this->id_prestamo = $id_prestamo;
        $this->id_libro = $id_libro;
        $this->cantidad = $cantidad;
    }
}
?>
