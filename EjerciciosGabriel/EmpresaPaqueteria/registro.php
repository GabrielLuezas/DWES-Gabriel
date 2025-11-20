<?php
require_once "clases/Conexion.php";

if ($_POST) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $con = new CConexion();
    $pdo = $con->ConexionBD();

    $sql = "INSERT INTO usuarios (username, password_hash) VALUES ('$username', '$password')";
    $pdo->query($sql);

    header("Location: login.php");
}
?>

<h2>Registro</h2>
<form method="POST">
    Usuario: <input type="text" name="username"><br><br>
    Contraseña: <input type="password" name="password"><br><br>
    <button type="submit">Registrar</button>
</form>
