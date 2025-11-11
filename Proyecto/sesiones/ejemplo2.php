<?php
session_start();
// ejemplo 2: login simulado
$mensaje = '';
if(isset($_POST['login'])){
    $user = trim($_POST['user'] ?? '');
    if($user !== ''){
        // simulación simple: guardamos el usuario en sesión
        $_SESSION['user'] = htmlspecialchars($user);
        $mensaje = 'Sesión iniciada como ' . $_SESSION['user'];
    } else {
        $mensaje = 'Introduce un nombre de usuario';
    }
}

if(isset($_GET['logout'])){
    session_unset();
    session_destroy();
    header('Location: ejemplo2.php');
    exit;
}

?><!doctype html><html lang="es"><head><meta charset="utf-8"><meta name='viewport' content='width=device-width,initial-scale=1'><title>Login Simulado</title><link rel="stylesheet" href="../assets/monokai.css"></head><body>
<div class="container">
  <div class="header">
    <div class="brand"><div class="logo">S2</div><div><div class="title">Login simulado (sesión)</div><div class="meta">Guarda un usuario en <code>$_SESSION</code></div></div></div>
    <div class="topbar">
      <a class="switch-btn" href="../cookies/">Cambiar a ejemplos Cookies</a>
      <a class="btn" href="index.php">Volver a Sesiones</a>
    </div>
  </div>

  <div class="execution">
    <h4>Estado de la sesión</h4>
    <?php if(isset($_SESSION['user'])): ?>
      <p>Usuario en sesión: <strong style="color:#a6e22e;"><?php echo $_SESSION['user']; ?></strong></p>
      <p><a class="btn" href="ejemplo2.php?logout=1">Cerrar sesión</a></p>
    <?php else: ?>
      <p>No hay usuario en sesión. Usa el formulario para iniciar.</p>
      <form method="post" style="margin-top:8px;">
        <label>Usuario: <input style="padding:8px;border-radius:6px;border:1px solid #333;background:#1b1b1b;color:#fff" name="user"></label>
        <button class="btn" name="login" type="submit">Iniciar sesión</button>
      </form>
    <?php endif; ?>
    <?php if($mensaje): ?><div style="margin-top:12px;" class="notice"><?php echo $mensaje; ?></div><?php endif; ?>
  </div>

  <div style="margin-top:18px;"><?php include_once('../assets/show_source.php'); show_source_block(__FILE__); ?></div>
  <div class="footer">Tip: las sesiones se almacenan en el servidor (por cookie de sesión). No uses este login en producción.</div>
</div>
</body></html>