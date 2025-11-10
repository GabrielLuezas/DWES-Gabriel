<!DOCTYPE html>
<html>
<head>
	<title>Hola PHP</title>
</head>
<body>


	<?php 

	echo rand(), " <br>";
	echo rand(1 ,6), "<br>";


	for ($i = 1; $i <= 10; $i++) {
		echo " Numero random " . $i .   " - " . rand(1, 10) . " <br>";
	}
	?>

</body>
</html>