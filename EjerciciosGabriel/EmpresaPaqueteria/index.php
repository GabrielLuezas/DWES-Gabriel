<?php
session_start();

require_once "clases/Conexion.php";
require_once "clases/Envio.php";
require_once "clases/EnvioEstandar.php";
require_once "clases/EnvioExpres.php";
require_once "clases/EnvioFragil.php";
require_once "textos.php";

if (!isset($_SESSION['historico_envios'])) {
    $_SESSION['historico_envios'] = [];
}

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

$currentUser = $_SESSION['usuario'];

$con = new CConexion();
$pdo = $con->ConexionBD();
$stmt = $pdo->query("SELECT username FROM usuarios");
$usuarios = $stmt->fetchAll(PDO::FETCH_COLUMN);

$remitente    = '';
$destinatario = '';
$destino      = '';
$tipo_envio   = '';
$zona         = '';
$peso         = '';
$seguro       = false;

$errorMsg = '';
$resultado = '';

if (isset($_SESSION['flash'])) {
    $flash = $_SESSION['flash'];
    $errorMsg = $flash['errorMsg'] ?? '';
    $resultado = $flash['resultado'] ?? '';
    
    if (isset($flash['formData'])) {
        $remitente    = $flash['formData']['remitente'] ?? '';
        $destinatario = $flash['formData']['destinatario'] ?? '';
        $destino      = $flash['formData']['destino'] ?? '';
        $tipo_envio   = $flash['formData']['tipo_envio'] ?? '';
        $zona         = $flash['formData']['zona'] ?? '';
        $peso         = $flash['formData']['peso'] ?? '';
        $seguro       = $flash['formData']['seguro'] ?? false;
    }
    unset($_SESSION['flash']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $remitente    = $_POST['remitente'] ?? '';
    $destinatario = $_POST['destinatario'] ?? '';
    $destino      = $_POST['destino'] ?? '';
    $tipo_envio   = $_POST['tipo_envio'] ?? '';
    $zona         = $_POST['zona'] ?? '';
    $peso         = $_POST['peso'] ?? '';
    $seguro       = isset($_POST['seguro']) ? true : false;

    $localErrorMsg = '';
    $localResultado = '';

    if ($remitente === '' || $destinatario === '' || $peso === '') {
        $localErrorMsg = TXT_ERROR_CAMPOS_OBLIGATORIOS;
    } else {

        $obj = null;
        switch ($tipo_envio) {
            case 'Estandar':
                $obj = new EnvioEstandar($remitente, $destinatario, $peso, $destino, $zona, $seguro);
                break;
            case 'Expres':
                $obj = new EnvioExpres($remitente, $destinatario, $peso, $destino, $zona, $seguro);
                break;
            case 'Fragil':
                $obj = new EnvioFragil($remitente, $destinatario, $peso, $destino, $zona, $seguro);
                break;
        }

        if ($obj) {
            $localResultado = $obj->calcularCoste();

            $_SESSION['historico_envios'][] = [
                'remitente'    => $remitente,
                'destinatario' => $destinatario,
                'destino'      => $destino,
                'tipo_envio'   => $tipo_envio,
                'zona'         => $zona,
                'peso'         => $peso,
                'seguro'       => $seguro,
                'coste'        => $localResultado,
                'fecha'        => date('Y-m-d H:i:s')
            ];
        } else {
            $localErrorMsg = TXT_ERROR_TIPO_ENVIO;
        }
    }

    $_SESSION['flash'] = [
        'errorMsg' => $localErrorMsg,
        'resultado' => $localResultado,
        'formData' => [
            'remitente'    => $remitente,
            'destinatario' => $destinatario,
            'destino'      => $destino,
            'tipo_envio'   => $tipo_envio,
            'zona'         => $zona,
            'peso'         => $peso,
            'seguro'       => $seguro
        ]
    ];

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulario de Envío</title>
</head>
<body>
  <div style="display: flex; justify-content: space-between; align-items: center;">
      <h1>Formulario de Envío</h1>
      <a href="logout.php"><button>Cerrar Sesión</button></a>
  </div>

  <?php if ($errorMsg): ?>
      <p style="color:red;"><?php echo $errorMsg; ?></p>
  <?php endif; ?>

  <?php if ($resultado): ?>
      <p style="color:green;">Resultado: <?php echo $resultado; ?> €</p>
  <?php endif; ?>

  <form method="post">
    <label>Remitente: <br>
      <select name="remitente">
          <option value="<?php echo htmlspecialchars($currentUser); ?>" selected><?php echo htmlspecialchars($currentUser); ?></option>
      </select>
    </label><br><br>

    <label>Destinatario: <br>
      <select name="destinatario">
          <?php foreach ($usuarios as $u): ?>
              <?php if ($u !== $currentUser): ?>
                  <option value="<?php echo htmlspecialchars($u); ?>" <?php if($destinatario==$u) echo 'selected'; ?>>
                      <?php echo htmlspecialchars($u); ?>
                  </option>
              <?php endif; ?>
          <?php endforeach; ?>
      </select>
    </label><br><br>

    <fieldset>
      <legend>Tipo de envío:</legend>
      <label><input type="radio" name="tipo_envio" value="Estandar" <?php if($tipo_envio=='Estandar') echo 'checked'; ?>> Estándar</label><br>
      <label><input type="radio" name="tipo_envio" value="Expres" <?php if($tipo_envio=='Expres') echo 'checked'; ?>> Exprés</label><br>
      <label><input type="radio" name="tipo_envio" value="Fragil" <?php if($tipo_envio=='Fragil') echo 'checked'; ?>> Frágil</label>
    </fieldset><br>

    <fieldset>
      <legend>Destino:</legend>
      <label><input type="radio" name="destino" value="Nacional" onclick="toggleZona()" <?php if($destino=='Nacional') echo 'checked'; ?>> Nacional</label><br>
      <label><input type="radio" name="destino" value="Internacional" onclick="toggleZona()" <?php if($destino=='Internacional') echo 'checked'; ?>> Internacional</label>
    </fieldset><br>

    <div id="zonaRow" style="display:<?php echo ($destino=='Internacional') ? 'block' : 'none'; ?>;">
      <label>
        Zona (solo si es Internacional):<br>
        <select name="zona">
          <option value="A" <?php if($zona=='A') echo 'selected'; ?>>Zona A</option>
          <option value="B" <?php if($zona=='B') echo 'selected'; ?>>Zona B</option>
          <option value="C" <?php if($zona=='C') echo 'selected'; ?>>Zona C</option>
        </select>
      </label><br><br>
    </div>

    <label>Peso (kg, obligatorio, mayor que 0):<br>
      <input type="number" name="peso" min="0.01" step="0.01" required value="<?php echo htmlspecialchars($peso); ?>">
    </label><br><br>

    <label><input type="checkbox" name="seguro" <?php if($seguro) echo 'checked'; ?>> Seguro</label><br><br>

    <button type="submit">Enviar</button>
  </form>

  <h2>Histórico de envíos</h2>
  <?php if(!empty($_SESSION['historico_envios'])): ?>
      <table border="1" cellpadding="5">
        <tr>
          <th>Remitente</th>
          <th>Destinatario</th>
          <th>Destino</th>
          <th>Tipo</th>
          <th>Zona</th>
          <th>Peso</th>
          <th>Seguro</th>
          <th>Coste (€)</th>
          <th>Fecha</th>
        </tr>
        <?php foreach($_SESSION['historico_envios'] as $envio): ?>
        <tr>
          <td><?php echo htmlspecialchars($envio['remitente']); ?></td>
          <td><?php echo htmlspecialchars($envio['destinatario']); ?></td>
          <td><?php echo htmlspecialchars($envio['destino']); ?></td>
          <td><?php echo htmlspecialchars($envio['tipo_envio']); ?></td>
          <td><?php echo htmlspecialchars($envio['zona']); ?></td>
          <td><?php echo htmlspecialchars($envio['peso']); ?></td>
          <td><?php echo $envio['seguro'] ? 'Sí' : 'No'; ?></td>
          <td><?php echo $envio['coste']; ?></td>
          <td><?php echo $envio['fecha']; ?></td>
        </tr>
        <?php endforeach; ?>
      </table>
  <?php else: ?>
      <p>No hay envíos todavía.</p>
  <?php endif; ?>

  <script>
    function toggleZona() {
      const internacional = document.querySelector('input[name="destino"][value="Internacional"]').checked;
      document.getElementById('zonaRow').style.display = internacional ? 'block' : 'none';
    }
  </script>
</body>
</html>
