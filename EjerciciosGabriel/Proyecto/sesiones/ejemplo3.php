<?php
session_start();

// Si se envía el formulario, guardamos todos los datos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['usuario'] = [
        'nombre' => htmlspecialchars($_POST['nombre']),
        'edad' => intval($_POST['edad']),
        'pais' => htmlspecialchars($_POST['pais'])
    ];
}

// Si se pulsa "Cerrar sesión", borramos los datos
if (isset($_POST['cerrar'])) {
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

$usuario = $_SESSION['usuario'] ?? null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejemplo 3 - Datos del usuario</title>
    <style>
        body { background: black; color: white; text-align: center; font-family: Arial; }
        input, button { padding: 8px; margin: 5px; border: none; border-radius: 6px; }
        button { background: #333; color: white; cursor: pointer; }
        button:hover { background: #555; }
        footer { margin-top: 50px; color: gray; font-size: 14px; }
    </style>
</head>
<body>
    <?php if (!$usuario): ?>
        <form method="post">
            <h2>Introduce tus datos:</h2>
            <input type="text" name="nombre" placeholder="Nombre" required><br>
            <input type="number" name="edad" placeholder="Edad" required><br>
            <input type="text" name="pais" placeholder="País" required><br>
            <button type="submit">Guardar</button>
        </form>
    <?php else: ?>
        <h1>Bienvenido, <?= $usuario['nombre']; ?>!</h1>
        <p>Edad: <?= $usuario['edad']; ?> años</p>
        <p>País: <?= $usuario['pais']; ?></p>
        <form method="post">
            <button type="submit" name="cerrar">Cerrar sesión</button>
        </form>
    <?php endif; ?>

    <footer>Presentación Sesión y Cookies - Gabriel Luezas y Andoni Pastrana</footer>
</body>
</html>
