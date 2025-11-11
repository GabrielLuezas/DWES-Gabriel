<?php
// preferencias mediante cookie (e.g. idioma)
$mensaje = '';
if(isset($_POST['guardar'])){
    $tema = $_POST['tema'] ?? 'oscuro';
    setcookie('pref_tema', $tema, time()+60*60*24*365); // 1 año
    $mensaje = 'Preferencia guardada: ' . htmlspecialchars($tema);
    header('Location: ejemplo2.php');
    exit;
}
$tema = $_COOKIE['pref_tema'] ?? 'no definida';
?><!doctype html><html lang="es"><head><meta charset="utf-8"><meta name='viewport' content='width=device-width,initial-scale=1'><title>Preferencias en Cookie</title><link rel="stylesheet" href="../assets/monokai.css"></head><body>
<div class="container">
  <div class="header">
    <div class="brand"><div class="logo">C2</div><div><div class="title">Preferencias (cookie)</div><div class="meta">Guardar tema o idioma en cookie</div></div></div>
    <div class="topbar">
      <a class="switch-btn" href="../sesiones/">Cambiar a ejemplos Sesiones</a>
      <a class="btn" href="index.php">Volver a Cookies</a>
    </div>
  </div>

  <div class="execution">
    <h4>Preferencia actual</h4>
    <p>Valor de <code>pref_tema</code>: <strong style="color:#a6e22e;"><?php echo htmlspecialchars($tema); ?></strong></p>
    <form method="post" style="margin-top:10px;">
      <label>Selecciona tema:
        <select name="tema" style="padding:8px;border-radius:6px;background:#1b1b1b;color:#fff;border:1px solid #333">
          <option value="oscuro">Oscuro</option>
          <option value="claro">Claro</option>
          <option value="system">Seguir sistema</option>
        </select>
      </label>
      <button class="btn" name="guardar" type="submit">Guardar preferencia</button>
    </form>
    <?php if($mensaje): ?><div style="margin-top:12px;" class="notice"><?php echo $mensaje; ?></div><?php endif; ?>
  </div>

  <div style="margin-top:18px;"><?php include_once('../assets/show_source.php'); show_source_block(__FILE__); ?></div>
  <div class="footer">La cookie de preferencias puede informar al servidor cómo personalizar respuestas.</div>
</div></body></html>