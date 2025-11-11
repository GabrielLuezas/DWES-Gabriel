<?php
require_once "Envio.php";

class EnvioEstandar extends Envio
{
    public function calcularCoste()
    {
        $coste = $this->peso * 2.00;
        return $this->aplicarExtras($coste);
    }

    
    private function aplicarExtras($coste)
    {
        if ($this->destino == "Internacional") {
            switch ($this->zona) {
                case 'A': $coste *= 1.30; break;
                case 'B': $coste *= 1.50; break;
                case 'C': $coste *= 1.80; break;
            }
        }

        if ($this->seguro) {
            $coste *= 1.02;
        }

        return $coste;
    }
}
?>
 