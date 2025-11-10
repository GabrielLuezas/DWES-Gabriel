<?php
include_once 'Persona.php';

class Profesor extends Persona {
    private $instituto;

    public function __construct($nombre, $telefono, $email, $instituto, Address $direccion = null) {
        parent::__construct($nombre, $telefono, $email, $direccion);
        $this->instituto = $instituto;
    }

    public function clasesImpartidas() {
        return ["PHP", "Java", "Bases de Datos"];
    }

    public function hacerCompra($monto) {
        $descuento = $monto * 0.10;
        $nombre = $this->getNombre();
        $dir = $this->direccion ? " Envio a \n" .$this->direccion->etiqueta() : "(sin direccion de envio)";
        return "Compra registrada por {$nombre}. Importe " . $monto - $descuento . "€ " . $dir;


    }

    public function getInstituto() {
        return $this->instituto;
    }
}
?>
