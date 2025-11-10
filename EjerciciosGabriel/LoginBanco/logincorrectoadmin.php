<?php
include_once 'datos.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel del Director</title>
  <style>
    table {
      border-collapse: collapse;
      width: 80%;
    }
    th, td {
      border: 1px solid #888;
      padding: 8px;
      text-align: center;
    }
    th {
      background-color: #eee;
    }
    button {
      padding: 5px 10px;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <h1>Bienvenido Director</h1>

  <table>
    <tr>
      <th>Usuario</th>
      <th>Nombre</th>
      <th>Apellido</th>
      <th>Número de cuenta</th>
      <th>Saldo</th>
      <th>Rol</th>
      <th>Acción</th>
    </tr>

    <?php foreach ($usuarios as $clave => $dato): ?>
      <tr>
        <td><?php echo $clave; ?></td>
        <td><?php echo $dato['nombre']; ?></td>
        <td><?php echo $dato['apellido']; ?></td>
        <td><?php echo $dato['numerocuenta']; ?></td>
        <td><?php echo $dato['saldo']; ?></td>
        <td><?php echo $dato['rol']; ?></td>
        <td>
          <form action="modificar.php" method="get" style="margin:0;">
            <input type="hidden" name="usuario" value="<?php echo $clave; ?>">
            <button type="submit">Modificar</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
</body>
</html>
