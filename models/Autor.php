<?php
// Este archivo define la clase Autor, que representa a los autores en el sistema.
// Contiene atributos como id_autor, nombre y nacionalidad, junto con métodos para acceder y modificar estos atributos.

class Autor {
    public $id_autor;
    public $nombre;
    public $nacionalidad;

    // Constructor: Inicializa los atributos de la clase Autor
    public function __construct($id_autor, $nombre, $nacionalidad) {
        $this->id_autor = $id_autor;
        $this->nombre = $nombre;
        $this->nacionalidad = $nacionalidad;
    }

    // Métodos getter y setter para acceder y modificar los atributos
    public function getIdAutor() {
        return $this->id_autor;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getNacionalidad() {
        return $this->nacionalidad;
    }

    public function setNacionalidad($nacionalidad) {
        $this->nacionalidad = $nacionalidad;
    }
}
?>
