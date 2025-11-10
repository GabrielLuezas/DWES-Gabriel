<!DOCTYPE html>
<html>
<head>
	<title>Fibonacci</title>
</head>
<body>
	<?php


		$numero1 = rand(1,20);
		$numero2 = rand(1,20);

		$op = 1;
		switch($op){ 
			case 1:
			echo "La suma de " . $numero1 . " + " . $numero2 . " es = " . $numero1+$numero2 ." <br>";
			break;
			case 2:
			echo "La resta de " . $numero1 . " - " . $numero2 . " es = " . $numero1-$numero2 ." <br>";
			break;
			case 3:
			echo "La multiplicacion de " . $numero1 . " * " . $numero2 . " es = " . $numero1*$numero2 ." <br>"; 
			break;
			case 4:
			echo "La divison de " . $numero1 . " / " . $numero2 . " es = " . $numero1/$numero2 ." <br>";
			break;
		}
    ?>
</body>
</html>