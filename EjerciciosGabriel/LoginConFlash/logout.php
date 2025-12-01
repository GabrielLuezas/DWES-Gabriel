<?php
session_start();

// Destruir todas las variables de sesión
$_SESSION = array();

// Destruir la sesión
session_destroy();

// Establecer mensaje flash para la página de login
session_start();
$_SESSION['flash_message'] = [
    'type' => 'success',
    'text' => 'Has cerrado sesión correctamente'
];

// Redirigir al login
header("Location: login.php");
exit();
?>
