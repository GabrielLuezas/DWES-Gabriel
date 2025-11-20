<?php
session_start();

if (isset($_POST['color'])) {
    $_SESSION['color_fondo'] = $_POST['color'];
}
$color = $_SESSION['color_fondo'] ?? '#ffffff';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejemplo 3 - Preferencias</title>
</head>
<body style="background-color: <?php echo htmlspecialchars($color); ?>;">
    <h2>Ejemplo 3 - Preferencias de Usuario con Sesión</h2>
    <form method="POST">
        <label>Elige un color de fondo:</label>
        <input type="color" name="color" value="<?php echo htmlspecialchars($color); ?>">
        <button type="submit">Guardar Preferencia</button>
    </form>
    <p><a href="cerrarSesion.php">Cerrar sesión</a></p>
</body>
</html>
