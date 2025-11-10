<?php
include_once 'Persona.php';

class Estudiante extends Persona {
    private $ciclo;

    public function __construct($nombre, $telefono, $email, $ciclo, Address $direccion = null) {
        parent::__construct($nombre, $telefono, $email, $direccion);
        $this->ciclo = $ciclo;
    }

    public function cursosRealizados() {
        return ["Programación", "Matemáticas", "POO"];
    }

    public function getCiclo() {
        return $this->ciclo;
    }
}
?>
