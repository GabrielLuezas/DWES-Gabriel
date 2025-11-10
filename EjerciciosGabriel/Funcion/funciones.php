<!DOCTYPE html>
<html>
<head>
    <title>Hola PHP</title>
</head>
<body>
    <?php
    
        $numerosAGenerar = 300;
        $numMin = 1;
        $numMax = 9;
        $primeroNumeroSecuencia = 3;
        $segudoNumeroSecuencia = 5;
        $tercerNumeroSecuencia = 7;
        $formato = "ultima";

        function rellenarArray($cantidad, $min, $max) {
            $array = [];
    
            for ($i = 0; $i < $cantidad; $i++) {
                $array[] = rand($min, $max);
            }
    
            return $array;
        }


        function retornarSecuencia($array, $numero1, $numero2, $numero3, $formato) {
            $rangos = [];

            switch ($formato) {
                case "primera":
                    for ($i = 0; $i < count($array) - 2; $i++) {
                        if ($array[$i] == $numero1 && $array[$i + 1] == $numero2 && $array[$i + 2] == $numero3) {
                            $rango = "$i-" . ($i + 2);
                            return "Primera secuencia encontrada en rango: $rango";
                        }
                    }
                    return "No se encontró ninguna secuencia";

                case "ultima":
                    for ($i = count($array) - 3; $i >= 0; $i--) {
                        if ($array[$i] == $numero1 && $array[$i + 1] == $numero2 && $array[$i + 2] == $numero3) {
                            $rango = "$i-" . ($i + 2);
                            return "Última secuencia encontrada en rango: $rango";
                        }
                    }
                    return "No se encontró ninguna secuencia (desde atrás)";

                case "todas":
                    for ($i = 0; $i < count($array) - 2; $i++) {
                        if ($array[$i] == $numero1 && $array[$i + 1] == $numero2 && $array[$i + 2] == $numero3) {
                            $rangos[] = "$i-" . ($i + 2);
                        }
                    }
                    if (count($rangos) > 0) {
                        return "Secuencias encontradas en rangos: " . implode(", ", $rangos);
                    } else {
                        return "No se encontraron secuencias";
                    }

                default:
                    return "Formato no válido. Usa 'primera', 'ultima' o 'todas'.";
            }
        }



        $array = rellenarArray($numerosAGenerar,$numMin ,$numMax);
        $resultado = retornarSecuencia($array, $primeroNumeroSecuencia,$segudoNumeroSecuencia,$tercerNumeroSecuencia, $formato);
        echo "El resultado es: " . $resultado;
    ?>
    
</body>
</html>

