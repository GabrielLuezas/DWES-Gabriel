<?php
session_start();
require_once "Conexion.php";

if (!isset($_SESSION['id_entrenador'])) {
    header("Location: login.php");
    exit;
}

$id_entrenador = $_SESSION['id_entrenador'];
$id_pokemon = $_POST['id_pokemon'] ?? null;
$nombre_pokemon = $_POST['nombre_pokemon'] ?? null;
$indice_json = $_POST['indice_json'] ?? null;

if (!$id_pokemon || !$nombre_pokemon) {
    header("Location: index.php");
    exit;
}

require_once "funciones.php"; // Include helper

$mensaje = "";
$tipoMensaje = "";
$flash = getFlashMessage();
if ($flash) {
    $mensaje = $flash['texto'];
    $tipoMensaje = $flash['tipo'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmar_venta'])) {
    $precio_inicio = $_POST['precio_inicio'] ?? 0;
    $duracion_minutos = $_POST['duracion'] ?? 60;
    
    // Recovery params in case of failure
    $id_pokemon_fail = $_POST['id_pokemon'];
    $nombre_pokemon_fail = $_POST['nombre_pokemon'];
    $indice_json_fail = $_POST['indice_json'];

    if ($precio_inicio > 0 && $duracion_minutos > 0) {
        $con = new CConexion();
        $pdo = $con->ConexionBD();
        
        if ($pdo) {
            try {
                // 1. Insertar en Subasta
                $fecha_fin = date('Y-m-d H:i:s', strtotime("+$duracion_minutos minutes"));
                $stmt = $pdo->prepare("INSERT INTO subasta (id_pokemon, precio_inicio, fecha_inicio, fecha_fin, id_vendedor) VALUES (:id_pokemon, :precio, NOW(), :fecha_fin, :id_vendedor)");
                $stmt->execute([
                    ':id_pokemon' => $id_pokemon,
                    ':precio' => $precio_inicio,
                    ':fecha_fin' => $fecha_fin,
                    ':id_vendedor' => $id_entrenador
                ]);
                
                // 2. Eliminar del JSON Global
                $globalJsonFile = FILE_JSON_GLOBAL;
                $globalData = file_exists($globalJsonFile) ? json_decode(file_get_contents($globalJsonFile), true) : [];
                
                if (isset($globalData[$id_entrenador]['pokemons'][$indice_json])) {
                    // Verificar que sea el mismo pokemon (por seguridad básica)
                    // Note: In strict PRG we might need to be careful, but here we just process.
                    if ($globalData[$id_entrenador]['pokemons'][$indice_json]['id_pokemon'] == $id_pokemon) {
                        unset($globalData[$id_entrenador]['pokemons'][$indice_json]);
                        // Reindexar array para evitar huecos
                        $globalData[$id_entrenador]['pokemons'] = array_values($globalData[$id_entrenador]['pokemons']);
                        file_put_contents($globalJsonFile, json_encode($globalData, JSON_PRETTY_PRINT));
                    }
                }
                
                setFlashMessage("Subasta creada con éxito.", "alert-success");
                header("Location: index.php"); // Redirigir al éxito
                exit;
                
            } catch (PDOException $e) {
                // Cannot easily redirect back to self with POST data without passing it all in URL or Session. 
                // For simplicity, we just redirect to index with error, or we could use session to recover form state (complex).
                // Let's redirect to index with error for safety/simplicity.
                setFlashMessage("Error al crear subasta: " . $e->getMessage(), "alert-error");
                header("Location: index.php"); 
                exit;
            }
        }
    } else {
        setFlashMessage("Datos inválidos. Precio y duración deben ser mayores a 0.", "alert-error");
        header("Location: index.php"); // Or back to previous logic if we could persist state
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Vender Pokemon</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <header>
        <h1>Subastar a <?php echo htmlspecialchars($nombre_pokemon); ?></h1>
    </header>
    <nav>
        <a href="index.php">Cancelar</a>
    </nav>

    <div class="container">
        <div class="form-container">
            <?php if ($mensaje): ?>
                <div class="alert <?php echo $tipoMensaje; ?>">
                    <?php echo $mensaje; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST">
                <input type="hidden" name="id_pokemon" value="<?php echo $id_pokemon; ?>">
                <input type="hidden" name="nombre_pokemon" value="<?php echo $nombre_pokemon; ?>">
                <input type="hidden" name="indice_json" value="<?php echo $indice_json; ?>">
                
                <div class="form-group">
                    <label for="precio_inicio">Precio de Salida ($)</label>
                    <input type="number" name="precio_inicio" id="precio_inicio" min="1" step="0.01" required>
                </div>
                
                <div class="form-group">
                    <label for="duracion">Duración (minutos)</label>
                    <input type="number" name="duracion" id="duracion" min="1" value="60" required>
                </div>
                
                <button type="submit" name="confirmar_venta" class="btn" style="width: 100%">Crear Subasta</button>
            </form>
        </div>
    </div>
</body>
</html>
