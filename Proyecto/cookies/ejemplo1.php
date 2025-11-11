<?php
// contador con cookies
$visitas = isset($_COOKIE['visitas']) ? (int)$_COOKIE['visitas'] : 0;
$visitas++;
setcookie('visitas', $visitas, time()+60*60*24*30); // 30 días
?><!doctype html><html lang="es"><head><meta charset="utf-8"><meta name='viewport' content='width=device-width,initial-scale=1'><title>Contador con Cookie</title><link rel="stylesheet" href="../assets/monokai.css"></head><body>
<div class="container">
  <div class="header">
    <div class="brand"><div class="logo">C1</div><div><div class="title">Contador con Cookie</div><div class="meta">Visitas guardadas en cookie</div></div></div>
    <div class="topbar">
      <a class="switch-btn" href="../sesiones/">Cambiar a ejemplos Sesiones</a>
      <a class="btn" href="index.php">Volver a Cookies</a>
    </div>
  </div>

  <div class="execution">
    <h4>Resultado</h4>
    <p>La cookie <code>visitas</code> contiene:</p>
    <div style="font-size:22px;font-weight:700;margin-top:8px;color:#a6e22e;"><?php echo $visitas; ?></div>
    <div style="margin-top:12px;">
      <a class="btn" href="?reset=1">Reiniciar cookie</a>
      <a class="btn secondary" href="borrarCookies.php" style="margin-left:8px;">Borrar cookies</a>
    </div>
    <?php if(isset($_GET['reset'])){ setcookie('visitas', '', time()-3600); header('Location: ejemplo1.php'); exit; } ?>
  </div>

  <div style="margin-top:18px;"><?php include_once('../assets/show_source.php'); show_source_block(__FILE__); ?></div>
  <div class="footer">Nota: las cookies residen en el navegador y tienen fecha de expiración.</div>
</div></body></html>