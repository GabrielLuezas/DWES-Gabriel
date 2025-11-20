<?php
session_start();
// Productos disponibles
$productos = [
    1 => "Camiseta",
    2 => "Pantalón",
    3 => "Zapatillas"
];
// Agregar producto al carrito
if (isset($_GET['add'])) {
    $id = (int)$_GET['add'];
    if (isset($productos[$id])) {
        $_SESSION['carrito'][$id] = ($_SESSION['carrito'][$id] ?? 0) + 1;
    }
}
// Vaciar carrito
if (isset($_GET['vaciar'])) {
    unset($_SESSION['carrito']);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejemplo 6 - Carrito de compras</title>
    <style>
        body { background: black; color: white; font-family: Arial; text-align: center; }
        a { color: #00bfff; text-decoration: none; }
        a:hover { text-decoration: underline; }
        .producto { margin: 10px; padding: 10px; border: 1px solid #555; display: inline-block; width: 150px; border-radius: 10px; }
        .carrito { margin-top: 30px; }
        footer { margin-top: 50px; color: gray; font-size: 14px; }
    </style>
</head>
<body>
    <h1>Tienda</h1>
    <?php foreach ($productos as $id => $nombre): ?>
        <div class="producto">
            <p><?= $nombre; ?></p>
            <a href="?add=<?= $id; ?>">Agregar al carrito</a>
        </div>
    <?php endforeach; ?>

    <div class="carrito">
        <h2>🛒 Carrito</h2>
        <?php if (!empty($_SESSION['carrito'])): ?>
            <ul style="list-style:none; padding:0;">
                <?php foreach ($_SESSION['carrito'] as $id => $cantidad): ?>
                    <li><?= $productos[$id]; ?> - <?= $cantidad; ?> unidades</li>
                <?php endforeach; ?>
            </ul>
            <a href="?vaciar=1" style="color:red;">Vaciar carrito</a>
        <?php else: ?>
            <p>El carrito está vacío.</p>
        <?php endif; ?>
    </div>

    <footer>Presentación Sesión y Cookies - Gabriel Luezas y Andoni Pastrana</footer>
</body>
</html>
