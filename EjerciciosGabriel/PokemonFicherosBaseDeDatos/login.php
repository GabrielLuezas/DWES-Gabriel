<?php
session_start();
require_once "Conexion.php";

$mensaje = "";
$tipoMensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($email && $password) {
        $con = new CConexion();
        $pdo = $con->ConexionBD();

        if ($pdo) {
            try {
                $stmt = $pdo->prepare("SELECT id_entrenador, nombre, password FROM entrenador WHERE email = :email");
                $stmt->execute([':email' => $email]);
                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($usuario && $usuario['password'] === $password) {
                    // Login correcto
                    $_SESSION['id_entrenador'] = $usuario['id_entrenador'];
                    $_SESSION['nombre_entrenador'] = $usuario['nombre'];
                    
                    if ($email === ADMIN_EMAIL) {
                        $_SESSION['es_admin'] = true;
                        header("Location: admin_panel.php");
                    } else {
                        header("Location: index.php");
                    }
                    exit;
                } else {
                    $mensaje = "Credenciales incorrectas.";
                    $tipoMensaje = "alert-error";
                }
            } catch (PDOException $e) {
                $mensaje = "Error en la base de datos: " . $e->getMessage();
                $tipoMensaje = "alert-error";
            }
        }
    } else {
        $mensaje = "Por favor completa todos los campos.";
        $tipoMensaje = "alert-error";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Subastas Pokemon</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <header>
        <h1>Acceso de Entrenador</h1>
    </header>
    <nav>
        <a href="login.php">Iniciar Sesión</a>
        <a href="registro.php">Registrarse</a>
    </nav>

    <div class="container">
        <div class="form-container">
            <?php if ($mensaje): ?>
                <div class="alert <?php echo $tipoMensaje; ?>">
                    <?php echo $mensaje; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="btn" style="width: 100%">Entrar</button>
            </form>
            <p style="text-align: center; margin-top: 1rem;">
                ¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a>
            </p>
        </div>
    </div>
</body>
</html>
