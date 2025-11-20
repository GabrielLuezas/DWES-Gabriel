<?php
header('P3P: CP="CAO DSP COR CURa ADMa DEVa OUR IND PHY ONL UNI COM NAV INT DEM PRE"');
header('Set-Cookie: iframe=ok; SameSite=None; Secure');

// Guardar un array como JSON en la cookie
$datos = ['usuario'=>'Gabriel','edad'=>25,'rol'=>'Alumno'];
setcookie('usuario', json_encode($datos), time()+3600, "/", "", false, false);

$mensaje = isset($_COOKIE['usuario']) ? "Cookie JSON: {$_COOKIE['usuario']}" : "Cookie no encontrada.";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejemplo 5 - Cookie JSON</title>
    <style>
        body { background:black; color:white; font-family:Arial; text-align:center; margin-top:70px; }
        footer { margin-top:50px; color:gray; font-size:14px; }
    </style>
</head>
<body>
    <h1><?= $mensaje; ?></h1>
    <footer>Presentación Sesión y Cookies - Gabriel Luezas y Andoni Pastrana</footer>
</body>
</html>
