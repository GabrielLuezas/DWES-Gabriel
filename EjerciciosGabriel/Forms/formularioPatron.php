<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Resultado del Generador</title>
</head>
<body>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numerosAGenerar = $_POST['numerosAGenerar'];
    $numMin = $_POST['numMin'];
    $numMax = $_POST['numMax'];
    $primeroNumeroSecuencia = $_POST['primeroNumeroSecuencia'];
    $segudoNumeroSecuencia = $_POST['segudoNumeroSecuencia'];
    $tercerNumeroSecuencia = $_POST['tercerNumeroSecuencia'];
    $formato = $_POST['formato'];

    function rellenarArray($cantidad, $min, $max) {
        $array = [];
        for ($i = 0; $i < $cantidad; $i++) {
            $array[] = rand($min, $max);
        }
        return $array;
    }

    function retornarSecuencia($array, $numero1, $numero2, $numero3, $formato) {
    $rangos = [];
    $arrayMarcado = $array;

    switch ($formato) {
        case "primera":
            for ($i = 0; $i < count($array) - 2; $i++) {
                if ($array[$i] == $numero1 && $array[$i + 1] == $numero2 && $array[$i + 2] == $numero3) {
                    $arrayMarcado[$i] = "<span style='color:red; font-weight:bold;'>{$array[$i]}</span>";
                    $arrayMarcado[$i + 1] = "<span style='color:red; font-weight:bold;'>{$array[$i + 1]}</span>";
                    $arrayMarcado[$i + 2] = "<span style='color:red; font-weight:bold;'>{$array[$i + 2]}</span>";
                    
                    $rango = "$i-" . ($i + 2);
                    return [
                        "mensaje" => "Primera secuencia encontrada en rango: $rango",
                        "arrayMarcado" => $arrayMarcado
                    ];
                }
            }
            return [
                "mensaje" => "No se encontró ninguna secuencia",
                "arrayMarcado" => $arrayMarcado
            ];

        case "ultima":
            for ($i = count($array) - 3; $i >= 0; $i--) {
                if ($array[$i] == $numero1 && $array[$i + 1] == $numero2 && $array[$i + 2] == $numero3) {
                    $arrayMarcado[$i] = "<span style='color:red; font-weight:bold;'>{$array[$i]}</span>";
                    $arrayMarcado[$i + 1] = "<span style='color:red; font-weight:bold;'>{$array[$i + 1]}</span>";
                    $arrayMarcado[$i + 2] = "<span style='color:red; font-weight:bold;'>{$array[$i + 2]}</span>";
                    
                    $rango = "$i-" . ($i + 2);
                    return [
                        "mensaje" => "Última secuencia encontrada en rango: $rango",
                        "arrayMarcado" => $arrayMarcado
                    ];
                }
            }
            return [
                "mensaje" => "No se encontró ninguna secuencia (desde atrás)",
                "arrayMarcado" => $arrayMarcado
            ];

        case "todas":
            for ($i = 0; $i < count($array) - 2; $i++) {
                if ($array[$i] == $numero1 && $array[$i + 1] == $numero2 && $array[$i + 2] == $numero3) {
                    $rangos[] = "$i-" . ($i + 2);
                    $arrayMarcado[$i] = "<span style='color:red; font-weight:bold;'>{$array[$i]}</span>";
                    $arrayMarcado[$i + 1] = "<span style='color:red; font-weight:bold;'>{$array[$i + 1]}</span>";
                    $arrayMarcado[$i + 2] = "<span style='color:red; font-weight:bold;'>{$array[$i + 2]}</span>";
                }
            }
            if (count($rangos) > 0) {
                return [
                    "mensaje" => "Secuencias encontradas en rangos: " . implode(", ", $rangos),
                    "arrayMarcado" => $arrayMarcado
                ];
            } else {
                return [
                    "mensaje" => "No se encontraron secuencias",
                    "arrayMarcado" => $arrayMarcado
                ];
            }
    }
}


    $array = rellenarArray($numerosAGenerar, $numMin, $numMax);
    $resultado = retornarSecuencia($array, $primeroNumeroSecuencia, $segudoNumeroSecuencia, $tercerNumeroSecuencia, $formato);

    echo "<h2>Secuencia</h2>";
    echo "<p>{$primeroNumeroSecuencia}{$segudoNumeroSecuencia}{$tercerNumeroSecuencia}</p>";
    echo "<h2>Resultado:</h2>";
    echo "<p>{$resultado['mensaje']}</p>";
    echo "<p><strong>Array generado:</strong><br>" . implode(" - ", $resultado['arrayMarcado']) . "</p>";
}
?>
<br><br>
<a href="formularioPatron.html">Volver al formulario</a>
</body>
</html>
