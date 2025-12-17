<?php
require_once "Conexion.php";

// funciones.php already included via require or we add it
require_once "funciones.php";

$mensaje = "";
$tipoMensaje = "";

// Check Flash
$flash = getFlashMessage();
if ($flash) {
    $mensaje = $flash['texto'];
    $tipoMensaje = $flash['tipo'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($nombre && $email && $password) {
        $con = new CConexion();
        $pdo = $con->ConexionBD();

        if ($pdo) {
            try {
                // Verificar si el email ya existe
                $stmt = $pdo->prepare("SELECT COUNT(*) FROM entrenador WHERE email = :email");
                $stmt->execute([':email' => $email]);
                if ($stmt->fetchColumn() > 0) {
                    setFlashMessage("El email ya está registrado.", "alert-error");
                    header("Location: registro.php");
                    exit;
                } else {
                    // Insertar nuevo entrenador
                    $stmt = $pdo->prepare("INSERT INTO entrenador (nombre, email, password, saldo) VALUES (:nombre, :email, :password, :saldo)");
                    $stmt->execute([
                        ':nombre' => $nombre,
                        ':email' => $email,
                        ':password' => $password,
                        ':saldo' => SALDO_INICIAL
                    ]);
                    setFlashMessage("Registro exitoso. ¡Ahora puedes iniciar sesión!", "alert-success");
                    header("Location: login.php");
                    exit;
                }
            } catch (PDOException $e) {
                setFlashMessage("Error en la base de datos: " . $e->getMessage(), "alert-error");
                header("Location: registro.php");
                exit;
            }
        }
    } else {
        setFlashMessage("Por favor completa todos los campos.", "alert-error");
        header("Location: registro.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Subastas Pokemon</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <header>
        <h1>Registro de Entrenador</h1>
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
                    <label for="nombre">Nombre de Entrenador</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="btn" style="width: 100%">Registrarse</button>
            </form>
            <p style="text-align: center; margin-top: 1rem;">
                ¿Ya tienes cuenta? <a href="login.php">Inicia sesión aquí</a>
            </p>
        </div>
    </div>
</body>
</html>
