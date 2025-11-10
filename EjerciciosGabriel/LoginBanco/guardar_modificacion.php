<?php
include_once 'datos.php';

$usuario = $_POST['usuario'];
$nuevacuenta = $_POST['numerocuenta'];
$nuevosaldo = $_POST['saldo'];
$nuevorol = $_POST['rol'];

if ($usuarios[$usuario]['rol'] === 'director') {
    $usuarios[$usuario]['numerocuenta'] = $nuevacuenta;
} else {
    $usuarios[$usuario]['numerocuenta'] = $nuevacuenta;
    $usuarios[$usuario]['saldo'] = $nuevosaldo;
    $usuarios[$usuario]['rol'] = $nuevorol;
}

$contenido = "<?php\n\$usuarios = " . var_export($usuarios, true) . ";\n?>";
file_put_contents('datos.php', $contenido);

echo "<h2>Datos actualizados correctamente.</h2>";
echo '<a href="logincorrectoadmin.php">Volver al panel</a>';
?>
