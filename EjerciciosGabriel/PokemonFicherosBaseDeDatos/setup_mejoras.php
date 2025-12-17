<?php
require_once "Conexion.php";

$con = new CConexion();
$pdo = $con->ConexionBD();

if ($pdo) {
    try {
        // 1. Alter Table
        $stmt = $pdo->query("ALTER TABLE subasta ADD COLUMN IF NOT EXISTS id_vendedor INT NULL");
        echo "Tabla subasta actualizada correctamente.<br>";

        // 2. Create Global JSON
        $globalJsonFile = 'pokemons_global.json';
        if (!file_exists($globalJsonFile)) {
            file_put_contents($globalJsonFile, json_encode([], JSON_PRETTY_PRINT));
            echo "Archivo pokemons_global.json creado.<br>";
        } else {
            echo "Archivo pokemons_global.json ya existe.<br>";
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
