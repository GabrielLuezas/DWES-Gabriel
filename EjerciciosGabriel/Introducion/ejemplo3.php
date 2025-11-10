<!DOCTYPE html>
<html>
<head>
	<title>Hola PHP</title>
</head>
<body>
	<?php
        $radio = 50;
        

        for ($i = 1; $i <= 10; $i++) {
			$radio = rand(30, 50);
			echo "<svg version='1.1' xmlns='http://www.w3.org/2000/svg'
            width='120' height='120' viewBox='0 0 120 120'>
            <circle cx='60' cy='60' r='$radio' fill='RoyalBlue' />
        	</svg>";
		}
    ?>
</body>
</html>