<?php
// Este archivo define la clase Usuario, que representa a los usuarios del sistema.
// Contiene atributos como id_usuario, nombre, correo, clave y rol.

class Usuario {
    public $id_usuario;
    public $nombre;
    public $correo;
    public $clave;
    public $rol;

    // Constructor: Inicializa los atributos de la clase Usuario
    public function __construct($id_usuario, $nombre, $correo, $clave, $rol) {
        $this->id_usuario = $id_usuario;
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->clave = $clave;
        $this->rol = $rol;
    }
}
?>
