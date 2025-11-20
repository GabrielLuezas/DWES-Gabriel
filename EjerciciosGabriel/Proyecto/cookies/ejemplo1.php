<?php
// Cabeceras para iframe
header('P3P: CP="CAO DSP COR CURa ADMa DEVa OUR IND PHY ONL UNI COM NAV INT DEM PRE"');
header('Set-Cookie: iframe=ok; SameSite=None; Secure');

// Crear o incrementar cookie de visitas
if (!isset($_COOKIE['visitas'])) {
    setcookie('visitas', 1, time() + 3600, "/", "", false, false);
    $mensaje = "Bienvenido por primera vez.";
} else {
    $nuevasVisitas = $_COOKIE['visitas'] + 1;
    setcookie('visitas', $nuevasVisitas, time() + 3600, "/", "", false, false);
    $mensaje = "Has visitado esta página {$nuevasVisitas} veces.";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejemplo 1 - Cookie simple</title>
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
