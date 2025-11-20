<?php
header('P3P: CP="CAO DSP COR CURa ADMa DEVa OUR IND PHY ONL UNI COM NAV INT DEM PRE"');
header('Set-Cookie: iframe=ok; SameSite=None; Secure');

// Cookie válida solo en esta ruta
setcookie('ruta', 'valor_ruta', time()+3600, "/", "", false, false);


$mensaje = isset($_COOKIE['ruta']) ? "Cookie con ruta activa: {$_COOKIE['ruta']}" : "Cookie de ruta no encontrada.";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejemplo 4 - Cookie con ruta</title>
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
