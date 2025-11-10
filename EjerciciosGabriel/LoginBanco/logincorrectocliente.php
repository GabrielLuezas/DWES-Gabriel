<?php
include_once 'datos.php';

if (!isset($_GET['usuario'])) {
    echo "Acceso no permitido";
    exit();
}

$usuario = $_GET['usuario'];
$cliente = $usuarios[$usuario];
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel del Cliente</title>
</head>
<body>
  <h1>Bienvenido <?php echo $cliente['nombre'] . " " . $cliente['apellido']; ?></h1>
  <p><strong>Número de cuenta:</strong> <?php echo $cliente['numerocuenta']; ?></p>
  <p><strong>Saldo actual:</strong> $<?php echo $cliente['saldo']; ?></p>
</body>
</html>
