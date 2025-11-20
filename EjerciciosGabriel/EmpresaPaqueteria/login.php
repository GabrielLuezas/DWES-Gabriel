<?php
require_once "./clases/Conexion.php";

session_start();

if ($_POST) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $con = new CConexion();
    $pdo = $con->ConexionBD();

    $sql = "SELECT * FROM usuarios 
            WHERE username='$username' AND password_hash='$password'";

    $result = $pdo->query($sql);
    $user = $result->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        $_SESSION['usuario'] = $user['username'];
        header("Location: index.php");
        exit;
    } else {
        echo "Usuario o contraseña incorrectos.";
    }
}
?>

<h2>Login</h2>
<form method="POST">
    Usuario: <input type="text" name="username"><br><br>
    Contraseña: <input type="password" name="password"><br><br>
    <button type="submit">Entrar</button>
</form>
