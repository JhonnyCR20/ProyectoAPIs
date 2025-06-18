<?php
// Este archivo define la clase Lector, que representa a los lectores en el sistema.
// Contiene atributos como id_lector, nombre, correo, teléfono y dirección, junto con métodos para acceder y modificar estos atributos.
class Lector {
    private $id_lector;
    private $nombre;
    private $correo;
    private $telefono;
    private $direccion;

    // Métodos getter para acceder a los atributos
    public function getId() { return $this->id_lector; }
    public function getNombre() { return $this->nombre; }
    public function getCorreo() { return $this->correo; }
    public function getTelefono() { return $this->telefono; }
    public function getDireccion() { return $this->direccion; }

    // Métodos setter para modificar los atributos
    public function setId($id) { $this->id_lector = $id; }
    public function setNombre($nombre) { $this->nombre = $nombre; }
    public function setCorreo($correo) { $this->correo = $correo; }
    public function setTelefono($telefono) { $this->telefono = $telefono; }
    public function setDireccion($direccion) { $this->direccion = $direccion; }

    // Método para convertir los atributos a un arreglo para JSON
    public function toArray() {
        return [
            'id_lector' => $this->id_lector,
            'nombre' => $this->nombre,
            'correo' => $this->correo,
            'telefono' => $this->telefono,
            'direccion' => $this->direccion
        ];
    }
}
?>
