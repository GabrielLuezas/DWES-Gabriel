<?php
// Guardar color en cookie
if (isset($_POST['color'])) {
    $color = htmlspecialchars($_POST['color']);
    setcookie('color', $color, time() + (86400 * 30)); // 30 días
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Borrar cookie
if (isset($_POST['borrar'])) {
    setcookie('color', '', time() - 3600);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Color guardado o por defecto
$color = $_COOKIE['color'] ?? "#ffffff";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejemplo Cookie - Color preferido</title>
    <style>
        body { background: black; color: white; text-align: center; font-family: Arial; margin-top: 80px; }
        input, button { padding: 8px; margin: 5px; border-radius: 6px; border: none; }
        button { background: #333; color: white; cursor: pointer; }
        footer { margin-top: 50px; color: gray; font-size: 14px; }
    </style>
</head>
<body>
    <h1 style="color: <?= $color; ?>">Tu color preferido (guardado con Cookie)</h1>
    <form method="post">
        <input type="color" name="color" value="<?= $color; ?>">
        <button type="submit">Guardar</button>
    </form>
    <form method="post">
        <button type="submit" name="borrar">Borrar Cookie</button>
    </form>

    <footer>Ejemplo Cookies - Gabriel Luezas y Andoni Pastrana</footer>
</body>
</html>
