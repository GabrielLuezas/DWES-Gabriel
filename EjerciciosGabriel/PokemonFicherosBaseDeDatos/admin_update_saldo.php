<?php
session_start();
require_once "Conexion.php";
require_once "funciones.php";

if (!isset($_SESSION['es_admin']) || !$_SESSION['es_admin']) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_entrenador = $_POST['id_entrenador'] ?? null;
    $nuevo_saldo = $_POST['saldo'] ?? null;

    if ($id_entrenador && $nuevo_saldo !== null) {
        try {
            $con = new CConexion();
            $pdo = $con->ConexionBD();
            
            $stmt = $pdo->prepare("UPDATE entrenador SET saldo = :saldo WHERE id_entrenador = :id");
            $stmt->execute([
                ':saldo' => $nuevo_saldo,
                ':id' => $id_entrenador
            ]);

            setFlashMessage("Saldo actualizado correctamente.", "alert-success");

        } catch (PDOException $e) {
            setFlashMessage("Error al actualizar saldo: " . $e->getMessage(), "alert-error");
        }
    } else {
        setFlashMessage("Datos inválidos.", "alert-error");
    }
}

header("Location: admin_panel.php");
exit;
?>
