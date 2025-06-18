<?php
// Este archivo define la clase Editorial, que representa las editoriales en el sistema.
// Contiene atributos como id_editorial, nombre y país, junto con métodos para acceder y modificar estos atributos.

class Editorial {
    public $id_editorial;
    public $nombre;
    public $pais;

    // Constructor: Inicializa los atributos de la clase Editorial
    public function __construct($id_editorial, $nombre, $pais) {
        $this->id_editorial = $id_editorial;
        $this->nombre = $nombre;
        $this->pais = $pais;
    }

    // Métodos getter y setter para acceder y modificar los atributos
    public function getIdEditorial() {
        return $this->id_editorial;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getPais() {
        return $this->pais;
    }

    public function setPais($pais) {
        $this->pais = $pais;
    }
}
?>
