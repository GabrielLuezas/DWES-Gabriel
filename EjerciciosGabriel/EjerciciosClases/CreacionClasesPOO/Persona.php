<?php
include_once 'Address.php';

class Persona {
    protected $nombre;
    protected $telefono;
    protected $email;
    protected $direccion;

    public function __construct($nombre, $telefono, $email, Address $direccion = null) {
        $this->nombre = $nombre;
        $this->telefono = $telefono;
        $this->email = $email;
        $this->direccion = $direccion;
    }

    public function hacerCompra($monto) {
        $nombre = $this->getNombre();
        $dir = $this->direccion ? " Envio a \n" .$this->direccion->etiqueta() : "(sin direccion de envio)";
        return "Compra registrada por {$nombre}. Importe " . $monto . "€ " . $dir;
    }

    public function getNombre() { return $this->nombre; }
    public function getTelefono() { return $this->telefono; }
    public function getEmail() { return $this->email; }

    public function getDireccion() {
        return $this->direccion ;
    }
}
?>
