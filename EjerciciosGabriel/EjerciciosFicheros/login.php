<?php
session_start();
require_once 'functions.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $users = getUsers();
    $found = false;


    foreach ($users as $user) {
        if ($user['email'] === $email && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            
            // Enviar notificación de login
            sendLoginNotification($user['email'], $user['nombre']);
            
            header('Location: dashboard.php');
            exit;
        }
    }


    $error = "Credenciales incorrectas.";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body { font-family: sans-serif; max-width: 400px; margin: 2rem auto; padding: 1rem; }
        form { display: flex; flex-direction: column; gap: 1rem; }
        input { padding: 0.5rem; }
        button { padding: 0.5rem; background: #28a745; color: white; border: none; cursor: pointer; }
        .error { color: red; }
    </style>
</head>
<body>
    <h2>Iniciar Sesión</h2>
    <?php if ($error): ?><p class="error"><?= $error ?></p><?php endif; ?>
    
    <form method="post">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Entrar</button>
    </form>
    <p>¿No tienes cuenta? <a href="register.php">Regístrate</a></p>
</body>
</html>
