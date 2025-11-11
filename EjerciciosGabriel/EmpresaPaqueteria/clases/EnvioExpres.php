<?php
require_once "Envio.php";

class EnvioExpres extends Envio
{
    public function calcularCoste()
    {
        $coste = $this->getPeso() * 3.50;

        if ($this->getPeso() > 10) {
            $coste += $this->getPeso() * 0.50;
        }
        
        return $this->aplicarExtras($coste);
    }

    
    private function aplicarExtras($coste)
    {
        if ($this->getDestino() == "Internacional") {
            switch ($this->getZona()) {
                case 'A': $coste *= 1.30; break;
                case 'B': $coste *= 1.50; break;
                case 'C': $coste *= 1.80; break;
            }
        }

        if ($this->getSeguro()) {
            $coste *= 1.02;
        }

        return $coste;
    }
}
?>
 