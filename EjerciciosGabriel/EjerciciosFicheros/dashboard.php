<?php
session_start();
require_once 'functions.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$currentUser = $_SESSION['user'];
$isAdmin = ($currentUser['role'] === 'admin');
$allUsers = $isAdmin ? getUsers() : [];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <style>
        body { font-family: sans-serif; max-width: 800px; margin: 2rem auto; padding: 1rem; }
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th, td { border: 1px solid #ccc; padding: 0.5rem; text-align: left; }
        th { background: #f4f4f4; }
        .logout { float: right; color: red; text-decoration: none; }
    </style>
</head>
<body>
    <a href="logout.php" class="logout">Cerrar Sesión</a>
    <h2>Bienvenido, <?= htmlspecialchars($currentUser['nombre']) ?></h2>
    
    <h3>Tus Datos</h3>
    <ul>
        <li><strong>Nombre:</strong> <?= htmlspecialchars($currentUser['nombre']) ?></li>
        <li><strong>Email:</strong> <?= htmlspecialchars($currentUser['email']) ?></li>
        <li><strong>Teléfono:</strong> <?= htmlspecialchars($currentUser['telefono']) ?></li>
        <li><strong>Rol:</strong> <?= htmlspecialchars($currentUser['role']) ?></li>
    </ul>

    <?php if ($isAdmin): ?>
        <h3>Panel de Administración (Todos los usuarios)</h3>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Rol</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($allUsers as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['nombre']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= htmlspecialchars($user['telefono']) ?></td>
                        <td><?= htmlspecialchars($user['role']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
