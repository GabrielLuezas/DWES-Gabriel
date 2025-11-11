<?php
// autenticación simple con cookie (solo demostración)
$mensaje='';
if(isset($_POST['login'])){
    $user = trim($_POST['user'] ?? '');
    if($user !== ''){
        // poner cookie de "autenticación" (NO seguro, solo demo)
        setcookie('auth_user', $user, time()+60*60*24*7); // 7 días
        header('Location: ejemplo3.php');
        exit;
    } else { $mensaje='Introduce un usuario'; }
}
if(isset($_GET['logout'])){
    setcookie('auth_user','',time()-3600);
    header('Location: ejemplo3.php');
    exit;
}
$user = $_COOKIE['auth_user'] ?? null;
?><!doctype html><html lang="es"><head><meta charset="utf-8"><meta name='viewport' content='width=device-width,initial-scale=1'><title>Auth con Cookie</title><link rel="stylesheet" href="../assets/monokai.css"></head><body>
<div class="container">
  <div class="header">
    <div class="brand"><div class="logo">C3</div><div><div class="title">Autenticación (cookie)</div><div class="meta">Demostración: guardar usuario en cookie</div></div></div>
    <div class="topbar">
      <a class="switch-btn" href="../sesiones/">Cambiar a ejemplos Sesiones</a>
      <a class="btn" href="index.php">Volver a Cookies</a>
    </div>
  </div>

  <div class="execution">
    <h4>Estado</h4>
    <?php if($user): ?>
      <p>Autenticado como: <strong style="color:#a6e22e;"><?php echo htmlspecialchars($user); ?></strong></p>
      <p><a class="btn" href="ejemplo3.php?logout=1">Cerrar (borrar cookie)</a></p>
    <?php else: ?>
      <p>No hay cookie de autenticación. Puedes "iniciar sesión" (demo).</p>
      <form method="post" style="margin-top:8px;"><label>Usuario: <input style="padding:8px;border-radius:6px;border:1px solid #333;background:#1b1b1b;color:#fff" name="user"></label><button class="btn" name="login" type="submit">Guardar cookie</button></form>
    <?php endif; ?>
    <?php if($mensaje): ?><div class="notice" style="margin-top:12px;"><?php echo $mensaje; ?></div><?php endif; ?>
  </div>

  <div style="margin-top:18px;"><?php include_once('../assets/show_source.php'); show_source_block(__FILE__); ?></div>
  <div class="footer">No uses cookies de autenticación sin medidas de seguridad (HTTPS, HttpOnly, firma).</div>
</div></body></html>