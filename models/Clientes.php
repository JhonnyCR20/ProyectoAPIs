<?php
// Este archivo define la clase Clientes, que representa a los clientes en el sistema.
// Contiene atributos básicos como id, nombre, apellidos y teléfono.

class Clientes {
    public $id;
    public $nombre;
    public $apellidos;
    public $telefono;

    // Constructor: Inicializa los atributos de la clase Clientes
    public function __construct($id, $nombre, $apellidos, $telefono) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->telefono = $telefono;
    }
}
?>