<?php
session_start();

if (isset($_POST['nombre'])) {
    $_SESSION['usuario'] = $_POST['nombre'];
}

if (isset($_SESSION['usuario'])) {
    echo "<h2>Bienvenido, " . htmlspecialchars($_SESSION['usuario']) . "!</h2>";
    echo "<p><a href='cerrarSesion.php'>Cerrar sesión</a></p>";
} else {
?>
<form method="POST">
    <h2>Ejemplo 2 - Iniciar Sesión</h2>
    <input type="text" name="nombre" placeholder="Tu nombre" required>
    <button type="submit">Iniciar sesión</button>
</form>
<?php
}
?>
