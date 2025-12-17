<?php
session_start();
require_once "Conexion.php";
require_once "funciones.php";

if (!isset($_SESSION['es_admin']) || !$_SESSION['es_admin']) {
    header("Location: login.php");
    exit;
}

$con = new CConexion();
$pdo = $con->ConexionBD();
$flash = getFlashMessage();
$mensaje = $flash['texto'] ?? "";
$tipo = $flash['tipo'] ?? "";

// 1. OBTENER LISTA DE TODOS LOS POKEMONS (BD)
$pokemonsBD = [];
if ($pdo) {
    $sql = "SELECT ep.id_entrenador, e.nombre as nombre_entrenador, p.nombre as nombre_pokemon, ep.fecha_adquisicion 
            FROM entrenador_pokemon ep
            JOIN entrenador e ON ep.id_entrenador = e.id_entrenador
            JOIN pokemon p ON ep.id_pokemon = p.id_pokemon
            ORDER BY e.nombre, ep.fecha_adquisicion DESC";
    $stmt = $pdo->query($sql);
    $pokemonsBD = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// 2. OBTENER POKEMONS DE JSON
$pokemonsJSON = [];
$globalJsonFile = FILE_JSON_GLOBAL;
if (file_exists($globalJsonFile)) {
    $data = json_decode(file_get_contents($globalJsonFile), true);
    if ($data) {
        foreach ($data as $idEntrenador => $info) {
            $nombreEntrenador = $info['nombre'] ?? "ID: $idEntrenador";
            foreach ($info['pokemons'] as $pk) {
                $pokemonsJSON[] = [
                    'nombre_entrenador' => $nombreEntrenador,
                    'nombre_pokemon' => $pk['nombre'],
                    'fecha_compra' => $pk['fecha_compra'] ?? 'N/A',
                    'origen' => 'JSON (No migrado)'
                ];
            }
        }
    }
}

// 3. OBTENER LISTA DE USUARIOS Y SALDOS
$entrenadores = [];
if ($pdo) {
    $stmt = $pdo->query("SELECT id_entrenador, nombre, email, saldo FROM entrenador ORDER BY nombre");
    $entrenadores = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// 4. OBTENER ESPECIES PARA SUBASTAS UNICAS
// Solamente mostrar pokemons que NO estén en una subasta (activa o finalizada) 
// Y QUE NO estén en entrenador_pokemon (propiedad de alguien)
$especiesDisponibles = [];
if ($pdo) {
    // Excluir IDs que están en subasta
    $sqlExcluirSubasta = "SELECT DISTINCT id_pokemon FROM subasta";
    // Excluir IDs que están asignados a un entrenador
    $sqlExcluirEntrenador = "SELECT DISTINCT id_pokemon FROM entrenador_pokemon";

    $sql = "SELECT id_pokemon, nombre FROM pokemon 
            WHERE id_pokemon NOT IN ($sqlExcluirSubasta) 
            AND id_pokemon NOT IN ($sqlExcluirEntrenador)
            ORDER BY id_pokemon ASC"; 
    
    $stmt = $pdo->query($sql);
    $especiesDisponibles = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración - Pokemon</title>
    <link rel="stylesheet" href="estilos.css">
    <style>
        .admin-section { margin-bottom: 2rem; padding: 1rem; background: #fff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .table-container { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #f4f4f4; }
        .badge-json { background-color: #ff9800; color: white; padding: 2px 6px; border-radius: 4px; font-size: 0.8em; }
        .badge-bd { background-color: #4caf50; color: white; padding: 2px 6px; border-radius: 4px; font-size: 0.8em; }
        
        .user-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1rem; }
        .user-card { background: #f9f9f9; padding: 1rem; border-radius: 8px; border: 1px solid #eee; }
        .form-inline { display: flex; gap: 0.5rem; margin-top: 0.5rem; }
    </style>
</head>
<body>
    <header style="background-color: #333; color: white;">
        <h1>Panel de Administración</h1>
    </header>
    <nav style="background-color: #444;">
        <a href="admin_panel.php" style="color: white; font-weight: bold;">Inicio Admin</a>
        <a href="logout.php" style="background-color: #d32f2f;">Cerrar Sesión</a>
    </nav>

    <div class="container">
        
        <?php if ($mensaje): ?>
            <div class="alert <?php echo $tipo; ?>"><?php echo $mensaje; ?></div>
        <?php endif; ?>

        <!-- Sección Gestión de Usuarios (Dinero) -->
        <div class="admin-section">
            <h2>Gestión de Entrenadores y Saldos</h2>
            <div class="user-grid">
                <?php foreach ($entrenadores as $user): ?>
                    <div class="user-card">
                        <h3><?php echo htmlspecialchars($user['nombre']); ?> <small>(ID: <?php echo $user['id_entrenador']; ?>)</small></h3>
                        <p><?php echo htmlspecialchars($user['email']); ?></p>
                        <form action="admin_update_saldo.php" method="POST" class="form-inline">
                            <input type="hidden" name="id_entrenador" value="<?php echo $user['id_entrenador']; ?>">
                            <input type="number" name="saldo" value="<?php echo $user['saldo']; ?>" step="0.01" style="width: 100px; padding: 5px;">
                            <button type="submit" class="btn" style="padding: 5px 10px; font-size: 0.9em;">Actualizar</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Sección Crear Subasta -->
        <div class="admin-section">
            <h2>Crear Nueva Subasta (Únicos)</h2>
            <p style="color: #666; font-size: 0.9em;">Nota: Solo aparecen Pokemons que nunca han sido subastados ni pertenecen a nadie.</p>
            
            <form action="admin_crear_subasta.php" method="POST" style="display: grid; grid-template-columns: 1fr 1fr 1fr auto; gap: 10px; align-items: end; margin-top: 1rem;">
                <div>
                    <label>Pokemon Disponible:</label>
                    <select name="id_pokemon" required style="width: 100%; padding: 8px;">
                        <option value="">Seleccione un Pokemon</option>
                        <?php foreach($especiesDisponibles as $esp): ?>
                            <option value="<?php echo $esp['id_pokemon']; ?>"><?php echo $esp['nombre']; ?></option>
                        <?php endforeach; ?>
                        <?php if(empty($especiesDisponibles)): ?>
                            <option value="" disabled>No hay pokemons únicos disponibles</option>
                        <?php endif; ?>
                    </select>
                </div>
                <div>
                    <label>Precio Inicial:</label>
                    <input type="number" name="precio" min="1" value="100" required style="width: 100%; padding: 8px;">
                </div>
                <div>
                    <label>Duración (minutos):</label>
                    <input type="number" name="duracion" min="1" value="60" required style="width: 100%; padding: 8px;">
                </div>
                <button type="submit" class="btn" style="background-color: #2196F3; color: white; height: 40px;">Crear Subasta</button>
            </form>
        </div>

        <!-- Sección Listado de Pokemons -->
        <div class="admin-section">
            <h2>Inventario Global de Pokemons</h2>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Entrenador</th>
                            <th>Pokemon</th>
                            <th>Fecha Adquisición</th>
                            <th>Fuente</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pokemonsBD as $p): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($p['nombre_entrenador']); ?></td>
                                <td><?php echo htmlspecialchars($p['nombre_pokemon']); ?></td>
                                <td><?php echo $p['fecha_adquisicion']; ?></td>
                                <td><span class="badge-bd">Base de Datos</span></td>
                            </tr>
                        <?php endforeach; ?>
                        
                        <?php foreach ($pokemonsJSON as $p): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($p['nombre_entrenador']); ?></td>
                                <td><?php echo htmlspecialchars($p['nombre_pokemon']); ?></td>
                                <td><?php echo $p['fecha_compra']; ?></td>
                                <td><span class="badge-json">JSON</span></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</body>
</html>
