<?php
require_once "Envio.php";
require_once __DIR__ . "/../constantes.php";

class EnvioExpres extends Envio
{
    public function calcularCoste()
    {
        $coste = $this->getPeso() * COSTE_BASE_EXPRES;

        if ($this->getPeso() > UMBRAL_PESO_EXPRES) {
            $coste += $this->getPeso() * RECARGO_PESO_EXPRES;
        }
        
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