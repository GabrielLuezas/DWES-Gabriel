<?php
include_once "Address.php";
include_once "Estudiante.php";
include_once "Persona.php";
include_once "Profesor.php";

$dir = new Address("Av. Los Pinos 123", "Lima", "Perú");
$prof = new Profesor("Luis García", "999999999", "luis@example.com", "UPC", $dir);
$est  = new Estudiante("Ana Torres", "987654321", "ana@example.com", "III Ciclo", $dir);

echo "<h3>Profesor:</h3>";
echo "Nombre: " . $prof->getNombre() . "<br>";
echo "Instituto: " . $prof->getInstituto() . "<br>";
echo $prof->hacerCompra(100);

echo "<h3>Estudiante:</h3>";
echo "Nombre: " . $est->getNombre() . "<br>";
echo "Ciclo: " . $est->getCiclo() . "<br>";
echo "Cursos realizados: " . implode(", ", $est->cursosRealizados()) . "<br>";
echo $est->hacerCompra(100);
?>
