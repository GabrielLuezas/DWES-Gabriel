<?php

$formulario_enviado = $_SERVER['REQUEST_METHOD'] === 'POST';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario en PHP</title>
</head>
<body>
    <h1>Formulario de ejemplo</h1>

    <form action="" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
        <br><br>

        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" required>
        <br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br><br>

        <label for="fecha">Fecha:</label>
        <input type="date" id="fecha" name="fecha" required>
        <br><br>

        <label for="color">Color favorito:</label>
        <input type="color" id="color" name="color">
        <br><br>

        <label for="cantidad">Cantidad (1-5):</label>
        <input type="number" id="cantidad" name="cantidad" min="1" max="5" required>
        <br><br>

        <label for="radio">Eugenio calvo </label>
        <input type="radio" id="radio" name="radio">
        <br><br>

        <label for="checkbox">Fuego </label>
        <input type="checkbox" id="checkbox" name="checkbox">
        <br><br>
        
        <label for="checkbox2">Planta </label>
        <input type="checkbox" id="checkbox2" name="checkbox2">
        <br><br>
        <label for="checkbox3">Agua </label>
        <input type="checkbox" id="checkbox3" name="checkbox3">
        <br><br>

        <button type="submit">Enviar</button>
    </form>

    <?php if ($formulario_enviado): ?>
        <h2>Datos enviados:</h2>
        <pre>
$_POST:
<?php
print_r($_POST);
?>
        </pre>
    <?php endif; ?>

</body>
</html>
