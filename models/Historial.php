<?php
// Este archivo define la clase Historial, que representa los registros de acciones realizadas por los lectores en el sistema.
// Contiene atributos como id_historial, id_lector, acción y fecha.

class Historial {
    public $id_historial;
    public $id_lector;
    public $accion;
    public $fecha;

    // Constructor: Inicializa los atributos de la clase Historial
    public function __construct($id_historial, $id_lector, $accion, $fecha) {
        $this->id_historial = $id_historial;
        $this->id_lector = $id_lector;
        $this->accion = $accion;
        $this->fecha = $fecha;
    }
}
?>
