<?php
// Iniciamos o reanudamos la sesión
session_start();

// Si la variable 'visitas' no existe, la inicializamos en 1
if (!isset($_SESSION['visitas'])) {
    $_SESSION['visitas'] = 1;
} else {
    // Si ya existe, incrementamos su valor
    $_SESSION['visitas']++;
}

// Si el usuario pulsa el botón "Reiniciar", destruimos la sesión
if (isset($_POST['reiniciar'])) {
    session_destroy(); // Borra todos los datos de la sesión
    header("Location: " . $_SERVER['PHP_SELF']); // Recarga la página
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejemplo 1 - Contador con reinicio</title>
    <style>
        body { background-color: black; color: white; text-align: center; font-family: Arial; margin-top: 80px; }
        button { padding: 8px 16px; background: #333; color: white; border: none; border-radius: 6px; cursor: pointer; }
        button:hover { background: #555; }
        footer { margin-top: 50px; color: gray; font-size: 14px; }
    </style>
</head>
<body>
    <h1>Has visitado esta página <?= $_SESSION['visitas']; ?> veces.</h1>
    <form method="post">
        <button type="submit" name="reiniciar">Reiniciar contador</button>
    </form>

    <footer>Presentación Sesión y Cookies - Gabriel Luezas y Andoni Pastrana</footer>
</body>
</html>
