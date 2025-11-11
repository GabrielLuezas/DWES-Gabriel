<?php
session_start();
// ejemplo 3: carrito simple en sesión
$productos = [
  1 => ['nombre'=>'Camiseta', 'precio'=>15],
  2 => ['nombre'=>'Taza', 'precio'=>8],
  3 => ['nombre'=>'Sticker', 'precio'=>2],
];

if(!isset($_SESSION['carrito'])) $_SESSION['carrito'] = [];

if(isset($_GET['add'])){
    $id = (int)$_GET['add'];
    if(isset($productos[$id])){
        $_SESSION['carrito'][] = $productos[$id];
    }
    header('Location: ejemplo3.php');
    exit;
}
if(isset($_GET['clear'])){
    $_SESSION['carrito']=[];
    header('Location: ejemplo3.php');
    exit;
}

?><!doctype html><html lang="es"><head><meta charset="utf-8"><meta name='viewport' content='width=device-width,initial-scale=1'><title>Carrito en Sesión</title><link rel="stylesheet" href="../assets/monokai.css"></head><body>
<div class="container">
  <div class="header">
    <div class="brand"><div class="logo">S3</div><div><div class="title">Carrito temporal (sesión)</div><div class="meta">Añade productos y se guardan en la sesión</div></div></div>
    <div class="topbar">
      <a class="switch-btn" href="../cookies/">Cambiar a ejemplos Cookies</a>
      <a class="btn" href="index.php">Volver a Sesiones</a>
    </div>
  </div>

  <div class="execution">
    <h4>Productos disponibles</h4>
    <div style="display:flex;gap:12px;flex-wrap:wrap;margin-top:8px;">
      <?php foreach($productos as $id=>$p): ?>
        <div style="background:#1b1b1b;padding:10px;border-radius:8px;width:160px;">
          <div style="font-weight:700;"><?php echo $p['nombre']; ?></div>
          <div style="color:#a6a28f">Precio: <?php echo $p['precio']; ?> €</div>
          <div style="margin-top:8px;"><a class="btn" href="?add=<?php echo $id; ?>">Añadir</a></div>
        </div>
      <?php endforeach; ?>
    </div>

    <h4 style="margin-top:18px;">Carrito (sesión)</h4>
    <?php if(empty($_SESSION['carrito'])): ?>
      <p class="notice">El carrito está vacío.</p>
    <?php else: ?>
      <ul>
        <?php $total=0; foreach($_SESSION['carrito'] as $it): $total+= $it['precio']; ?>
          <li><?php echo $it['nombre']; ?> — <?php echo $it['precio']; ?> €</li>
        <?php endforeach; ?>
      </ul>
      <div style="margin-top:8px;font-weight:700">Total: <?php echo $total; ?> €</div>
      <div style="margin-top:10px;"><a class="btn secondary" href="?clear=1">Vaciar carrito</a></div>
    <?php endif; ?>
  </div>

  <div style="margin-top:18px;"><?php include_once('../assets/show_source.php'); show_source_block(__FILE__); ?></div>
  <div class="footer">Ejemplo: almacenar pequeñas estructuras en la sesión para estado temporal.</div>
</div>
</body></html>