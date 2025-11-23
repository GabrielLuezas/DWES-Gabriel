<?php
require_once "Envio.php";
require_once __DIR__ . "/../constantes.php";

class EnvioFragil extends Envio
{
    public function calcularCoste()
    {
        $coste = ($this->peso * COSTE_BASE_FRAGIL) + COSTE_FIJO_FRAGIL;
        return $this->aplicarExtras($coste);
    }

    private function aplicarExtras($coste)
    {
        if ($this->destino == "Internacional") {
            switch ($this->zona) {
                case 'A': $coste *= MULT_ZONA_A; break;
                case 'B': $coste *= MULT_ZONA_B; break;
                case 'C': $coste *= MULT_ZONA_C; break;
            }
        }

        if ($this->seguro) {
            $coste *= MULT_SEGURO;
        }

        return $coste;
    }
}
?>
