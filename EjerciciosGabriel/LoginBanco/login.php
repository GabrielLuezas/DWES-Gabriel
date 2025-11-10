<?php
include_once 'datos.php'; 

$usuario = $_POST['usuario'];
$password = $_POST['password'];


if (isset($usuarios[$usuario]) && $usuarios[$usuario]['password'] === $password) {
    if ($usuarios[$usuario]['rol'] === "director") {
        header("Location: logincorrectoadmin.php");
        exit();
    } else {
        header("Location: logincorrectocliente.php?usuario=$usuario");
        exit();
    }
} else {
    echo "<h1>Usuario o contraseña incorrectos</h1>";
}

?>