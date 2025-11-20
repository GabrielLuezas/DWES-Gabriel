<?php
header('P3P: CP="CAO DSP COR CURa ADMa DEVa OUR IND PHY ONL UNI COM NAV INT DEM PRE"');
header('Set-Cookie: iframe=ok; SameSite=None; Secure');

if (isset($_POST['reiniciar'])) {
    setcookie('visitas', '', time() - 3600, "/", "", false, false);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

$mensaje = isset($_COOKIE['visitas']) ? "Visitas actuales: {$_COOKIE['visitas']}" : "No hay cookie activa.";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejemplo 2 - Reiniciar cookie</title>
    <style>
        body { background:black; color:white; font-family:Arial; text-align:center; margin-top:70px; }
        button { padding:8px 16px; margin-top:20px; cursor:pointer; border-radius:6px; border:none; background:#444; color:white; }
        button:hover { background:#666; }
        footer { margin-top:50px; color:gray; font-size:14px; }
    </style>
</head>
<body>
    <h1><?= $mensaje; ?></h1>
    <form method="post">
        <button type="submit" name="reiniciar">Reiniciar cookie</button>
    </form>
    <footer>Presentación Sesión y Cookies - Gabriel Luezas y Andoni Pastrana</footer>
</body>
</html>
