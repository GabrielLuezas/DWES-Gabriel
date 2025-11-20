<?php
session_start();

// Inicializar array de tareas si no existe
if (!isset($_SESSION['tareas'])) {
    $_SESSION['tareas'] = [];
}

// Añadir tarea
if (isset($_POST['tarea']) && trim($_POST['tarea']) !== '') {
    $_SESSION['tareas'][] = htmlspecialchars($_POST['tarea']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Borrar todas las tareas
if (isset($_POST['borrar'])) {
    unset($_SESSION['tareas']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejemplo Sesión - Lista temporal de tareas</title>
    <style>
        body { background: #0f0f0f; color: #fff; text-align: center; font-family: Arial; margin-top: 60px; }
        input[type="text"] { padding: 8px; width: 250px; border-radius: 6px; border: none; }
        button { padding: 8px 12px; margin: 5px; border: none; border-radius: 6px; background: #5fd1ff; color: #000; cursor: pointer; }
        button:hover { filter: brightness(1.2); }
        ul { list-style: none; padding: 0; margin-top: 20px; }
        li { background: #222; margin: 6px auto; padding: 8px 12px; border-radius: 6px; width: 300px; }
        footer { margin-top: 50px; color: gray; font-size: 14px; }
    </style>
</head>
<body>
    <h1>📝 Lista temporal de tareas (Sesión)</h1>

    <form method="post">
        <input type="text" name="tarea" placeholder="Escribe una tarea...">
        <button type="submit">Añadir</button>
    </form>

    <?php if (!empty($_SESSION['tareas'])): ?>
        <ul>
            <?php foreach ($_SESSION['tareas'] as $t): ?>
                <li><?= $t ?></li>
            <?php endforeach; ?>
        </ul>
        <form method="post">
            <button name="borrar">Borrar todas</button>
        </form>
    <?php else: ?>
        <p>No hay tareas en esta sesión.</p>
    <?php endif; ?>

    <footer>Ejemplo de Sesión - Gabriel Luezas y Andoni Pastrana</footer>
</body>
</html>
