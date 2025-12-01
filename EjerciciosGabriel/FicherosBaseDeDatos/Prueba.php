<?php
require_once "./Conexion.php";

$jsonFile = 'usuarios.json';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_json'])) {
    $nombre = $_POST['nombre'] ?? '';
    if (!empty($nombre)) {
        $currentData = file_exists($jsonFile) ? json_decode(file_get_contents($jsonFile), true) : [];
        $currentData[] = ['nombre' => $nombre];
        file_put_contents($jsonFile, json_encode($currentData, JSON_PRETTY_PRINT));
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['migrate_db'])) {
    if (file_exists($jsonFile)) {
        $users = json_decode(file_get_contents($jsonFile), true);
        if ($users) {
            $con = new CConexion();
            $pdo = $con->ConexionBD();
            if ($pdo) {
                try {
                    $stmt = $pdo->prepare("INSERT INTO usuario (nombre) VALUES (:nombre)");
                    foreach ($users as $user) {
                        $stmt->execute([':nombre' => $user['nombre']]);
                    }
                    file_put_contents($jsonFile, json_encode([], JSON_PRETTY_PRINT));
                    echo "<p style='color: green;'>Usuarios migrados a la Base de Datos correctamente.</p>";
                } catch (PDOException $e) {
                    echo "<p style='color: red;'>Error al migrar: " . $e->getMessage() . "</p>";
                }
            }
        }
    }
}

$jsonUsers = file_exists($jsonFile) ? json_decode(file_get_contents($jsonFile), true) : [];

$con = new CConexion();
$pdo = $con->ConexionBD();
$dbUsers = [];
if ($pdo) {
    $stmt = $pdo->query("SELECT nombre FROM usuario");
    $dbUsers = $stmt->fetchAll(PDO::FETCH_COLUMN);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Prueba JSON y BD</title>
</head>
<body>
    <h1>Gestión de Usuarios</h1>

    <form method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" required>
        <button type="submit" name="add_json">Guardar en JSON</button>
    </form>

    <hr>

    <h2>Usuarios en JSON (FicherosBaseDeDatos)</h2>
    <?php if (!empty($jsonUsers)): ?>
        <ul>
            <?php foreach ($jsonUsers as $u): ?>
                <li><?php echo htmlspecialchars($u['nombre']); ?></li>
            <?php endforeach; ?>
        </ul>
        <form method="post">
            <button type="submit" name="migrate_db">Pasar a BD</button>
        </form>
    <?php else: ?>
        <p>No hay usuarios en el fichero JSON.</p>
    <?php endif; ?>

    <hr>

    <h2>Usuarios en Base de Datos</h2>
    <ul>
        <?php foreach ($dbUsers as $u): ?>
            <li><?php echo htmlspecialchars($u); ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>