<?php
include_once 'datos.php';

if (!isset($_GET['usuario'])) {
    echo "Usuario no especificado.";
    exit();
}

$usuario = $_GET['usuario'];
$dato = $usuarios[$usuario];
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Modificar usuario</title>
</head>
<body>
  <h2>Modificar datos de <?php echo $dato['nombre'] . " " . $dato['apellido']; ?></h2>

  <form action="guardar_modificacion.php" method="post">
    <input type="hidden" name="usuario" value="<?php echo $usuario; ?>">

    <p><strong>Rol actual:</strong> <?php echo $dato['rol']; ?></p>

    <label for="numerocuenta">Número de cuenta:</label>
    <input type="text" name="numerocuenta" id="numerocuenta" value="<?php echo $dato['numerocuenta']; ?>" required><br><br>

    <?php if ($dato['rol'] !== 'director'): ?>
      <label for="saldo">Saldo:</label>
      <input type="number" name="saldo" id="saldo" value="<?php echo $dato['saldo']; ?>" required><br><br>

      <label for="rol">Rol:</label>
      <select name="rol" id="rol">
        <option value="cliente" <?php if($dato['rol'] === 'cliente') echo 'selected'; ?>>Cliente</option>
        <option value="director" <?php if($dato['rol'] === 'director') echo 'selected'; ?>>Director</option>
      </select><br><br>
    <?php else: ?>
      <input type="hidden" name="saldo" value="<?php echo $dato['saldo']; ?>">
      <input type="hidden" name="rol" value="<?php echo $dato['rol']; ?>">
      <p><em>No puedes modificar tu saldo ni tu rol.</em></p>
    <?php endif; ?>

    <button type="submit">Guardar cambios</button>
  </form>

  <br>
  <a href="logincorrectoadmin.php">Volver al panel</a>
</body>
</html>
