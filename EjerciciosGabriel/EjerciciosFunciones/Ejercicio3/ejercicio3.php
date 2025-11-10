<?php

$valor = $_POST['valor'];
$origen = $_POST['origen'];
$destino = $_POST['destino'];

function celsiusAFahrenheit($c) { 
    return ($c * 9/5) + 32; 
}
function celsiusAKelvin($c) { 
    return $c + 273.15; 
}
function fahrenheitACelsius($f) { 
    return ($f - 32) * 5/9; 
}
function kelvinACelsius($k) { 
    return $k - 273.15; 
}


function convertirTemperatura($valor, $origen, $destino) {
    if ($origen === $destino) return $valor;

    switch ($origen) {
        case 'F': $celsius = fahrenheitACelsius($valor); break;
        case 'K': $celsius = kelvinACelsius($valor); break;
        default:  $celsius = $valor; break;
    }

    switch ($destino) {
        case 'F': return celsiusAFahrenheit($celsius);
        case 'K': return celsiusAKelvin($celsius);
        default:  return $celsius;
    }
}



echo "El resultado es: " . convertirTemperatura($valor, $origen, $destino);

?>