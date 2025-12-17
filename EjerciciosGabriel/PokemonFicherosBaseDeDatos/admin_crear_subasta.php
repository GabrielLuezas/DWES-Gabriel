<?php
session_start();
require_once "Conexion.php";
require_once "funciones.php";

if (!isset($_SESSION['es_admin']) || !$_SESSION['es_admin']) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pokemon = $_POST['id_pokemon'] ?? null;
    $precio = $_POST['precio'] ?? null;
    $duracion = $_POST['duracion'] ?? null;

    if ($id_pokemon && $precio && $duracion) {
        try {
            $con = new CConexion();
            $pdo = $con->ConexionBD();

            // Calcular fecha fin
            $minutos = intval($duracion);
            $fecha_fin = date('Y-m-d H:i:s', strtotime("+$minutos minutes"));

            // Insertar subasta (id_vendedor NULL porque es el Admin/Sistema)
            $stmt = $pdo->prepare("INSERT INTO subasta (id_pokemon, fecha_inicio, fecha_fin, precio_inicio, precio_final, id_vendedor, id_ganador) 
                                   VALUES (:id_pokemon, NOW(), :fecha_fin, :precio, NULL, NULL, NULL)");
            
            $stmt->execute([
                ':id_pokemon' => $id_pokemon,
                ':fecha_fin' => $fecha_fin,
                ':precio' => $precio
            ]);

            setFlashMessage("Subasta creada exitosamente.", "alert-success");

        } catch (PDOException $e) {
            setFlashMessage("Error al crear subasta: " . $e->getMessage(), "alert-error");
        }
    } else {
        setFlashMessage("Faltan datos para crear la subasta.", "alert-error");
    }
}

header("Location: admin_panel.php");
exit;
?>
