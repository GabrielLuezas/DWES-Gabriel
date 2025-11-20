<?php
session_start();
$usuarioCorrecto = "admin";
$passwordCorrecta = "1234";
// Comprobamos el login
if (isset($_POST['usuario'], $_POST['password'])) {
    if ($_POST['usuario'] === $usuarioCorrecto && $_POST['password'] === $passwordCorrecta) {
        $_SESSION['logueado'] = true;
        $_SESSION['usuario'] = $usuarioCorrecto;
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}
// Cerrar sesión
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejemplo 4 - Login con sesión</title>
    <style>
        body { background: black; color: white; text-align: center; font-family: Arial; margin-top: 60px; }
        input, button { padding: 8px; margin: 5px; border: none; border-radius: 6px; }
        button { background: #333; color: white; cursor: pointer; }
        button:hover { background: #555; }
        .error { color: red; }
        footer { margin-top: 50px; color: gray; font-size: 14px; }
    </style>
</head>
<body>
    <?php if (empty($_SESSION['logueado'])): ?>
        <h2>Iniciar sesión</h2>
        <?php if (!empty($error)): ?><p class="error"><?= $error; ?></p><?php endif; ?>
        <form method="post">
            <input type="text" name="usuario" placeholder="Usuario" required><br>
            <input type="password" name="password" placeholder="Contraseña" required><br>
            <button type="submit">Entrar</button>
        </form>
    <?php else: ?>
        <h1>Bienvenido, <?= $_SESSION['usuario']; ?> ✅</h1>
        <a href="?logout=1" style="color:white;">Cerrar sesión</a>
    <?php endif; ?>

    <footer>Presentación Sesión y Cookies - Gabriel Luezas y Andoni Pastrana</footer>
</body>
</html>
