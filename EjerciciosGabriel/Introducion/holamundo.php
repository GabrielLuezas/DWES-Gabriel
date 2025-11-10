<!DOCTYPE html>
<html>
<head>
	<title>Hola PHP</title>
</head>
<body>


	<?php echo "¡Hola, mundo! , Soy Gabriel <br>"; 
	echo "Casteo <br>";
	$palabra = "hola";
	$float = 2.5;
	$numero = 2;

	echo" Variable string = $palabra - " ; 
	echo gettype($palabra);  
	echo "<br>";
	echo" Variable float = $float - "; 
	echo gettype($float);
	echo "<br>";
	echo" Variable numero = $numero - "; 
	echo gettype($numero);  
	echo "<br>";

	$palabra = 2;
	$float = "hola";
	$numero = 2.5;
	echo "Re-Casteo <br>";

	echo" Variable int = $palabra - " ; 
	echo gettype($palabra); 
	echo "<br>";
	echo" Variable String = $float - "; 
	echo gettype($float);  
	echo "<br>";
	echo" Variable float = $numero - "; 
	echo gettype($numero);  
	echo "<br>";

	?>

</body>
</html>