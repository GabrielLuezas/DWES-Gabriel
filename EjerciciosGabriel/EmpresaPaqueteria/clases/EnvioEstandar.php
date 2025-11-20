<?php
require_once "Envio.php";
require_once __DIR__ . "/../constantes.php";

class EnvioEstandar extends Envio
{
    public function calcularCoste()
{
    $coste = $this->getPeso() * COSTE_BASE_ESTANDAR;
    return $this->aplicarExtras($coste);
}

private function aplicarExtras($coste)
{
    if ($this->getDestino() == "Internacional") {
        switch ($this->getZona()) {
            case 'A': $coste *= MULT_ZONA_A; break;
            case 'B': $coste *= MULT_ZONA_B; break;
            case 'C': $coste *= MULT_ZONA_C; break;
        }
    }

    if ($this->getSeguro()) {
        $coste *= MULT_SEGURO;
    }

    return $coste;
}

}
?>