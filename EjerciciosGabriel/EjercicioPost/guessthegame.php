<?php
session_start();

if (isset($_POST['reiniciar'])) {
    $_SESSION['numero'] = rand(1, 100);
    $mensaje = "Se ha generado un nuevo número secreto.";
}

if (!isset($_SESSION['numero'])) {
    $_SESSION['numero'] = rand(1, 100);
    $mensaje = "Se ha generado un número secreto. ¡Intenta adivinarlo!";
}

$secreto = $_SESSION['numero'];

if (isset($_POST['intento']) && $_POST['intento'] !== "") {
    $intento = intval($_POST['intento']);

    if ($intento < $secreto) {
        $mensaje = "El número secreto es mayor.";
    } elseif ($intento > $secreto) {
        $mensaje = "El número secreto es menor.";
    } else {
        $mensaje = "¡Has acertado! Pulsa reiniciar para jugar otra vez.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Adivina el número</title>
</head>
<body>

<h2>Adivina el número (1 a 100)</h2>

<form method="POST">
    <label>Introduce un número:</label>
    <input type="number" name="intento" min="1" max="100">
    <button type="submit">Probar</button>
    <button type="submit" name="reiniciar">Reiniciar</button>
</form>

<p><?php echo $mensaje; ?></p>

</body>
</html>
