<?php




session_start();

if (!isset($_SESSION['becarios'])) {
    $_SESSION['becarios'] = 1;
} else {
    $_SESSION['becarios']++;
    echo session_id();
    if($_SESSION['becarios'] == 6){
        session_destroy(); 
        header("Location: " . $_SERVER['PHP_SELF']); 
        echo session_id();
    }
}


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejemplo sesiones</title>
    <style>
        body { background-color: black; color: white; text-align: center; font-family: Arial; margin-top: 80px; }
        button { padding: 8px 16px; background: #333; color: white; border: none; border-radius: 6px; cursor: pointer; }
        button:hover { background: #555; }
        footer { margin-top: 50px; color: gray; font-size: 14px; }
    </style>
</head>
<body>
    <h1>Has visitado esta página <?= $_SESSION['becarios']; ?> veces.</h1>
    <footer>Presentación Sesión y Cookies - Gabriel Luezas y Andoni Pastrana</footer>
</body>
</html>
