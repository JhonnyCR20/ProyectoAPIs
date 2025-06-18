<?php
// Este archivo define la clase Categoria, que representa las categorías de libros en el sistema.
// Contiene atributos como id_categoria, nombre y descripción, junto con métodos para acceder y modificar estos atributos.

class Categoria {
    public $id_categoria;
    public $nombre;
    public $descripcion;

    // Constructor: Inicializa los atributos de la clase Categoria
    public function __construct($id_categoria, $nombre, $descripcion) {
        $this->id_categoria = $id_categoria;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
    }

    // Métodos getter y setter para acceder y modificar los atributos
    public function getIdCategoria() {
        return $this->id_categoria;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }
}
?>
