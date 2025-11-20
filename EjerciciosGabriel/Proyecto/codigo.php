<?php
// Verificamos si el usuario envió el formulario
if (isset($_POST['idioma'])) {
    $idioma = $_POST['idioma'];
    // Guardamos la cookie por 7 días
    setcookie('idioma', $idioma, time() + (7 * 24 * 60 * 60));
    // Recargamos para aplicar el cambio
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Si el usuario desea borrar la cookie
if (isset($_GET['borrar'])) {
    setcookie('idioma', '', time() - 3600);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Leemos la cookie si existe
$idiomaGuardado = $_COOKIE['idioma'] ?? null;
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Preferencia de idioma con Cookie</title>
<style>
  body {
    font-family: Arial, sans-serif;
    background: #1e1e1e;
    color: #f8f8f2;
    text-align: center;
    padding-top: 60px;
  }
  select, button {
    padding: 10px;
    border-radius: 6px;
    border: none;
    font-size: 15px;
  }
  button {
    background: #66d9ef;
    color: #0d0d0d;
    font-weight: 700;
    cursor: pointer;
  }
  button:hover {
    transform: scale(1.05);
  }
  a {
    color: #f92672;
    text-decoration: none;
    margin-top: 20px;
    display: inline-block;
  }
</style>
</head>
<body>

<h2>🌍 Preferencia de idioma</h2>

<?php if (!$idiomaGuardado): ?>
  <p>Selecciona tu idioma preferido:</p>
  <form method="post">
    <select name="idioma" required>
      <option value="">-- Selecciona --</option>
      <option value="es">Español 🇪🇸</option>
      <option value="en">English 🇬🇧</option>
      <option value="fr">Français 🇫🇷</option>
    </select>
    <button type="submit">Guardar</button>
  </form>
<?php else: ?>
  <?php
    // Mostramos el contenido según la cookie
    switch ($idiomaGuardado) {
      case 'es':
        echo "<h3>👋 Bienvenido! Has elegido Español.</h3>";
        echo "<p>Tu contenido se mostrará en español.</p>";
        break;
      case 'en':
        echo "<h3>👋 Welcome! You chose English.</h3>";
        echo "<p>Your content will be displayed in English.</p>";
        break;
      case 'fr':
        echo "<h3>👋 Bonjour! Vous avez choisi le Français.</h3>";
        echo "<p>Votre contenu s'affichera en français.</p>";
        break;
      default:
        echo "<p>Idioma desconocido.</p>";
    }
  ?>
  <a href="?borrar=1">🗑️ Cambiar idioma</a>
<?php endif; ?>

</body>
</html>