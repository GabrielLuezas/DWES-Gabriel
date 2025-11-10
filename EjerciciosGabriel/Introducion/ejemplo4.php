<!DOCTYPE html>
<html>
<head>
	<title>Fibonacci</title>
</head>
<body>
	<?php

		$acumulador = 0;
		$maximo = 99;

        for ($i = 1; $i <= $maximo; $i++) {
			$acumulador += rand(1,10);
		}

		$media = $acumulador / $maximo;

		echo $media;


		
    ?>
</body>
</html>