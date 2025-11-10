<?php
$frutas = ["Manzana", "Pera", "Banana", "Kiwi"];

$ejemplo = ["H","O","L","A"];

$separador = ", ";

$separador2 = " - ";

$cadena = implode($separador, $frutas);

$cadena2 = implode($ejemplo);

$cadena3 = implode($separador2 , $ejemplo);

echo "Resultado: " . $cadena . " <br>";

echo "Resultado sin separado: " . $cadena2. "<br>";

echo "Resultado -: " . $cadena3;
?>