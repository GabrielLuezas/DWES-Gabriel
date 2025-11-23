<?php
require_once 'functions.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($nombre) || empty($email) || empty($telefono) || empty($password)) {
        $error = "Todos los campos son obligatorios.";
    } elseif (emailExists($email)) {
        $error = "El email ya está registrado.";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $newUser = [
            'nombre' => $nombre,
            'email' => $email,
            'telefono' => $telefono,
            'password' => $hashedPassword,
            'role' => 'user' 
        ];

        $users = getUsers();
        if (empty($users)) {
            $newUser['role'] = 'admin';
        }

        saveUser($newUser);
        sendConfirmationEmail($email, $nombre);
        $success = "Registro completado con éxito. Se ha enviado un correo de confirmación.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <style>
        body { font-family: sans-serif; max-width: 400px; margin: 2rem auto; padding: 1rem; }
        form { display: flex; flex-direction: column; gap: 1rem; }
        input { padding: 0.5rem; }
        button { padding: 0.5rem; background: #007bff; color: white; border: none; cursor: pointer; }
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>
    <h2>Registro</h2>
    <?php if ($error): ?><p class="error"><?= $error ?></p><?php endif; ?>
    <?php if ($success): ?><p class="success"><?= $success ?></p><?php endif; ?>
    
    <form method="post">
        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="tel" name="telefono" placeholder="Teléfono" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Registrarse</button>
    </form>
    <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>
</body>
</html>
