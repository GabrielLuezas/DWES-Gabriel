<?php
session_start(); // Iniciamos la sesión

// Guardamos el nombre si el usuario envía el formulario
if (isset($_POST['nombre']) && !empty($_POST['nombre'])) {
    $_SESSION['nombre'] = htmlspecialchars($_POST['nombre']); 
}

// Si el usuario cierra sesión, destruimos la sesión actual
if (isset($_POST['cerrar'])) {
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

$nombre = $_SESSION['nombre'] ?? null; // Recupera el nombre si existe
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejemplo 2 - Guardar nombre en sesión</title>
    <style>
        body { background: black; color: white; text-align: center; font-family: Arial; margin-top: 60px; }
        input, button { padding: 8px; border-radius: 6px; border: none; margin: 5px; }
        button { background: #333; color: white; cursor: pointer; }
        button:hover { background: #555; }
        footer { margin-top: 50px; color: gray; font-size: 14px; }
    </style>
</head>
<body>
    <?php if (!$nombre): ?>
        <h2>Introduce tu nombre:</h2>
        <form method="post">
            <input type="text" name="nombre" required placeholder="Tu nombre">
            <button type="submit">Guardar</button>
        </form>
    <?php else: ?>
        <h1>Hola, <?= $nombre; ?> 👋</h1>
        <form method="post">
            <button type="submit" name="cerrar">Cerrar sesión</button>
        </form>
    <?php endif; ?>

    <footer>Presentación Sesión y Cookies - Gabriel Luezas y Andoni Pastrana</footer>
</body>
</html>
