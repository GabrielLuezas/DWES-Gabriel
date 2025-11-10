<?php
session_start();

if (!isset($_SESSION['visitas'])) {
    $_SESSION['visitas'] = 1;
} else {
    $_SESSION['visitas']++;
}
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Ejemplo 1 - Contador</title></head>
<body>
<h2>Ejemplo 1 - Contador de Sesiones</h2>
<p>Has visitado esta página <strong><?php echo $_SESSION['visitas']; ?></strong> veces en esta sesión.</p>
<p><a href="sesionesEjemplo1.php">Actualizar página</a></p>
<p><a href="cerrarSesion.php">Cerrar sesión</a></p>
</body>
</html>
