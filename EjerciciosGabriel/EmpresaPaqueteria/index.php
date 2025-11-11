<?php
require_once "clases/Envio.php";
require_once "clases/EnvioEstandar.php";
require_once "clases/EnvioExpres.php";
require_once "clases/EnvioFragil.php";
require_once "textos.php";
?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulario de Envío</title>
</head>
<body>
  <h1>Formulario de Envío</h1>

  <form method="post">
    <label>
      Remitente: <br>
      <input type="text" name="remitente" >
    </label>
    <br><br>

    <label>
      Destinatario: <br>
      <input type="text" name="destinatario" >
    </label>
    <br><br>

    <fieldset>
      <legend>Tipo de envío:</legend>
      <label><input type="radio" name="tipo_envio" value="Estandar" checked> Estándar</label><br>
      <label><input type="radio" name="tipo_envio" value="Expres"> Exprés</label><br>
      <label><input type="radio" name="tipo_envio" value="Fragil"> Frágil</label>
    </fieldset>
    <br>

    <fieldset>
      <legend>Destino:</legend>
      <label><input type="radio" name="destino" value="Nacional" checked onclick="toggleZona()"> Nacional</label><br>
      <label><input type="radio" name="destino" value="Internacional" onclick="toggleZona()"> Internacional</label>
    </fieldset>
    <br>

    <div id="zonaRow" style="display:none;">
      <label>
        Zona (solo si es Internacional):<br>
        <select name="zona">
          <option value="A">Zona A</option>
          <option value="B">Zona B</option>
          <option value="C">Zona C</option>
        </select>
      </label>
      <br><br>
    </div>

    <label>
      Peso (kg, obligatorio, mayor que 0):<br>
      <input type="number" name="peso" min="0.01" step="0.01" required>
    </label>
    <br><br>

    <label>
      <input type="checkbox" name="seguro"> Seguro
    </label>
    <br><br>

    <button type="submit">Enviar</button>
  </form>

  <script>
    function toggleZona() {
      const internacional = document.querySelector('input[name="destino"][value="Internacional"]').checked;
      document.getElementById('zonaRow').style.display = internacional ? 'block' : 'none';
    }
  </script>
</body>

<?php
    $remitente = $_POST['remitente'];
    $destinatario = $_POST['destinatario'];
    $destino = $_POST['destino'];
    $tipo_envio = $_POST['tipo_envio'];
    $zona = $_POST['zona'];
    $peso = $_POST['peso'];
    $seguro = $_POST['seguro'];

    try {
        if ($remitente === '' || $destinatario === '') throw new InvalidArgumentException(TXT_REMITENTE_Y_DESTINATARIO_SON_OBLIGATORIOS);
        
    } catch (Throwable $e) {
        $errorMsg = TXT_ERROR_EN_LOS_DATOS_INTRODUCIDOS_INTENTALO_DE_NUEVO;
    }


    switch ($tipo_envio) {
        case 'Estandar':
            $obj = new EnvioEstandar($remitente,$destinatario,$peso, $destino, $zona, $seguro);
        break;
        case 'Expres':
            $obj = new EnvioExpres($remitente,$destinatario,$peso, $destino, $zona, $seguro);
        break;
        case 'Fragil':
            $envioObj = new EnvioFragil($remitente,$destinatario, $peso, $destino, $zona, $seguro);
        break;
        default:
            $envioObj = null;
    }

    echo $obj->calcularCoste();





?>

</html>
