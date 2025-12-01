<?php
require_once "./Conexion.php";

    $con = new CConexion();
    $pdo = $con->ConexionBD();

    $stmt = $pdo->query("SELECT nombre FROM usuario");
    $usuarios = $stmt->fetchAll(PDO::FETCH_COLUMN);
?>

<h2>Prueba</h2>

<?php foreach ($usuarios as $u): ?>
    <?php echo htmlspecialchars($u); ?>
<?php endforeach; ?>