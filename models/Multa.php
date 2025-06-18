<?php
// Este archivo define la clase Multa, que representa las multas en el sistema.
// Contiene atributos como id_multa, id_prestamo, monto y estado de pago.

class Multa {
    public $id_multa;
    public $id_prestamo;
    public $monto;
    public $pagado;

    // Constructor: Inicializa los atributos de la clase Multa
    public function __construct($id_multa, $id_prestamo, $monto, $pagado) {
        $this->id_multa = $id_multa;
        $this->id_prestamo = $id_prestamo;
        $this->monto = $monto;
        $this->pagado = $pagado;
    }
}
?>
