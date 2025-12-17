<?php
session_start();
require_once "funciones.php"; // Include helper functions
require_once "Conexion.php";

// Check PRG Flash
$flash = getFlashMessage();
if ($flash) {
    // If we have a flash message, we might want to display it.
    // However, index.php structure uses specific variables. 
    // We will assign it to $mensaje if appropriate or create a display block.
    // For now, let's just ensure we can show it.
    $mensajeFlash = $flash['texto'];
    $tipoMensajeFlash = $flash['tipo'];
}

if (!isset($_SESSION['id_entrenador'])) {
    header("Location: login.php");
    exit;
}

$id_entrenador = $_SESSION['id_entrenador'];
$nombre_entrenador = $_SESSION['nombre_entrenador'];

$con = new CConexion();
$pdo = $con->ConexionBD();

// --- Lógica para procesar ganadores (simplificada: se ejecuta al cargar index) ---
// Buscar subastas finalizadas sin ganador asignado
try {
    $stmt = $pdo->query("SELECT s.id_subasta, s.id_pokemon, p.nombre as nombre_pokemon, s.id_vendedor
                         FROM subasta s 
                         JOIN pokemon p ON s.id_pokemon = p.id_pokemon
                         WHERE s.fecha_fin <= NOW() AND s.id_ganador IS NULL");
    $subastasFinalizadas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($subastasFinalizadas as $subasta) {
        try {
            // Buscar la puja más alta
            $stmtPuja = $pdo->prepare("SELECT id_entrenador, cantidad FROM puja WHERE id_subasta = :id ORDER BY cantidad DESC LIMIT 1");
            $stmtPuja->execute([':id' => $subasta['id_subasta']]);
            $ganador = $stmtPuja->fetch(PDO::FETCH_ASSOC);
    
            if ($ganador) {
                // Actualizar subasta con ganador y precio final
                $updateSubasta = $pdo->prepare("UPDATE subasta SET id_ganador = :id_ganador, precio_final = :precio WHERE id_subasta = :id_subasta");
                $updateSubasta->execute([
                    ':id_ganador' => $ganador['id_entrenador'],
                    ':precio' => $ganador['cantidad'],
                    ':id_subasta' => $subasta['id_subasta']
                ]);
    
                // Guardar en JSON Global
                $globalJsonFile = FILE_JSON_GLOBAL;
                $globalData = file_exists($globalJsonFile) ? json_decode(file_get_contents($globalJsonFile), true) : [];
                
                // Asegurar estructura por usuario
                $idGanador = $ganador['id_entrenador'];
                if (!isset($globalData[$idGanador])) {
                    // Obtener nombre real del entrenador
                    $stmtNombre = $pdo->prepare("SELECT nombre FROM entrenador WHERE id_entrenador = :id");
                    $stmtNombre->execute([':id' => $idGanador]);
                    $nombreEntrenadorReal = $stmtNombre->fetchColumn(); 

                    $globalData[$idGanador] = [
                        'nombre' => $nombreEntrenadorReal ?: ('Entrenador ' . $idGanador),
                        'pokemons' => []
                    ];
                }
    
                $globalData[$idGanador]['pokemons'][] = [
                    'id_pokemon' => $subasta['id_pokemon'],
                    'nombre' => $subasta['nombre_pokemon'],
                    'precio_compra' => $ganador['cantidad'],
                    'fecha_compra' => date('Y-m-d H:i:s')
                ];
                
                file_put_contents($globalJsonFile, json_encode($globalData, JSON_PRETTY_PRINT));
                
                // NO Restar saldo al ganador (YA SE RESTÓ AL PUJAR)
                 
                 // Si hay vendedor (usuario), sumar saldo
                 if ($subasta['id_vendedor']) {
                     $updateVendedor = $pdo->prepare("UPDATE entrenador SET saldo = saldo + :precio WHERE id_entrenador = :id_vendedor");
                     $updateVendedor->execute([
                         ':precio' => $ganador['cantidad'],
                         ':id_vendedor' => $subasta['id_vendedor']
                     ]);
                 }
    
            } else {
                // Nadie pujó
                // Si tiene vendedor, devolver al JSON del vendedor
                if ($subasta['id_vendedor']) {
                     $globalJsonFile = FILE_JSON_GLOBAL;
                     $globalData = file_exists($globalJsonFile) ? json_decode(file_get_contents($globalJsonFile), true) : [];
                     
                     $idVendedor = $subasta['id_vendedor'];
                     if (!isset($globalData[$idVendedor])) {
                         $globalData[$idVendedor] = ['pokemons' => []];
                     }
                     
                     $globalData[$idVendedor]['pokemons'][] = [
                        'id_pokemon' => $subasta['id_pokemon'],
                        'nombre' => $subasta['nombre_pokemon'],
                        'precio_compra' => 0, // Devuelto
                        'fecha_compra' => date('Y-m-d H:i:s')
                     ];
                     file_put_contents($globalJsonFile, json_encode($globalData, JSON_PRETTY_PRINT));
                }
                
                // Marcar como "desierta" (id_ganador = 0)
                 $updateSubasta = $pdo->prepare("UPDATE subasta SET id_ganador = 0 WHERE id_subasta = :id_subasta");
                 $updateSubasta->execute([':id_subasta' => $subasta['id_subasta']]);
            }
        } catch (Exception $e) {
            // Ignorar error en esta subasta individual para no bloquear las demás
            // Podríamos loguear el error: error_log($e->getMessage());
        }
    }
} catch (PDOException $e) {
    // Manejo de errores silencioso o log
}

// --- Consultas para la vista ---

// 1. Subastas Activas
$subastasActivas = [];
if ($pdo) {
    $stmt = $pdo->query("SELECT s.id_subasta, p.nombre, s.precio_inicio, s.fecha_fin, 
                         (SELECT MAX(cantidad) FROM puja WHERE id_subasta = s.id_subasta) as puja_actual
                         FROM subasta s
                         JOIN pokemon p ON s.id_pokemon = p.id_pokemon
                         WHERE s.fecha_fin > NOW() AND s.id_ganador IS NULL");
    $subastasActivas = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// 2. Subastas donde he pujado
$misPujas = [];
if ($pdo) {
    $stmt = $pdo->prepare("SELECT DISTINCT s.id_subasta, p.nombre, s.fecha_fin,
                           (SELECT MAX(cantidad) FROM puja WHERE id_subasta = s.id_subasta) as precio_actual,
                           (SELECT MAX(cantidad) FROM puja WHERE id_subasta = s.id_subasta AND id_entrenador = :id) as mi_puja_maxima
                           FROM puja pu
                           JOIN subasta s ON pu.id_subasta = s.id_subasta
                           JOIN pokemon p ON s.id_pokemon = p.id_pokemon
                           WHERE pu.id_entrenador = :id AND s.fecha_fin > NOW()"); 
    $stmt->execute([':id' => $id_entrenador]);
    $misPujas = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// 3. Pokemons Comprados (JSON Global)
$globalJsonFile = FILE_JSON_GLOBAL;
$globalData = file_exists($globalJsonFile) ? json_decode(file_get_contents($globalJsonFile), true) : [];
$pokemonsComprados = $globalData[$id_entrenador]['pokemons'] ?? [];

// --- Lógica Migrar a BD ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['migrar_bd'])) {
    if (!empty($pokemonsComprados)) {
        try {
            $stmtInsert = $pdo->prepare("INSERT INTO entrenador_pokemon (id_entrenador, id_pokemon, fecha_adquisicion) VALUES (:id_entrenador, :id_pokemon, :fecha)");
            foreach ($pokemonsComprados as $pk) {
                // Verificar si ya existe
                $check = $pdo->prepare("SELECT COUNT(*) FROM entrenador_pokemon WHERE id_entrenador = :id AND id_pokemon = :pk");
                $check->execute([':id' => $id_entrenador, ':pk' => $pk['id_pokemon']]);
                if ($check->fetchColumn() == 0) {
                     $stmtInsert->execute([
                        ':id_entrenador' => $id_entrenador,
                        ':id_pokemon' => $pk['id_pokemon'],
                        ':fecha' => $pk['fecha_compra']
                    ]);
                }
            }
            // Actualizar JSON Global
            if (isset($globalData[$id_entrenador])) {
                $globalData[$id_entrenador]['pokemons'] = [];
                file_put_contents($globalJsonFile, json_encode($globalData, JSON_PRETTY_PRINT));
            }
            
            setFlashMessage("Pokemons migrados a Base de Datos con éxito.", "alert-success");
            header("Location: index.php");
            exit;

        } catch (PDOException $e) {
            setFlashMessage("Error al migrar: " . $e->getMessage(), "alert-error");
            header("Location: index.php");
            exit;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Principal - Subastas Pokemon</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <header>
        <h1>Bienvenido, <?php echo htmlspecialchars($nombre_entrenador); ?></h1>
    </header>
    <nav>
        <a href="#activas">Subastas Activas</a>
        <a href="#mispujas">Mis Pujas</a>
        <a href="#comprados">Pokemons Comprados</a>
        <a href="logout.php" style="background-color: #d32f2f;">Cerrar Sesión</a>
    </nav>

    <div class="container">
        
        <!-- Subastas Activas -->
        <h2 id="activas">Subastas Activas</h2>
        <div class="card-grid">
            <?php if (empty($subastasActivas)): ?>
                <p>No hay subastas activas en este momento.</p>
            <?php else: ?>
                <?php foreach ($subastasActivas as $subasta): ?>
                    <div class="card">
                        <h3><?php echo htmlspecialchars($subasta['nombre']); ?></h3>
                        <p>Precio actual: <strong><?php echo $subasta['puja_actual'] ?? $subasta['precio_inicio']; ?></strong></p>
                        <p>Termina: <span class="countdown" data-endtime="<?php echo str_replace(' ', 'T', $subasta['fecha_fin']) . 'Z'; ?>"><?php echo $subasta['fecha_fin']; ?></span></p>

                        <a href="subasta.php?id=<?php echo $subasta['id_subasta']; ?>" class="btn">Entrar a la Puja</a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <hr style="margin: 3rem 0;">

        <!-- Mis Pujas -->
        <h2 id="mispujas">Subastas donde has pujado</h2>
        <div class="card-grid">
            <?php if (empty($misPujas)): ?>
                <p>No has pujado en ninguna subasta activa.</p>
            <?php else: ?>
                <?php foreach ($misPujas as $puja): ?>
                    <?php 
                        $ganando = ($puja['mi_puja_maxima'] >= $puja['precio_actual']);
                        $clase = $ganando ? 'winning' : 'losing';
                        $estado = $ganando ? 'Vas ganando' : 'Te han superado';
                    ?>
                    <div class="card <?php echo $clase; ?>">
                        <h3><?php echo htmlspecialchars($puja['nombre']); ?></h3>
                        <p>Tu puja: <?php echo $puja['mi_puja_maxima']; ?></p>
                        <p>Puja más alta: <?php echo $puja['precio_actual']; ?></p>
                        <p><strong><?php echo $estado; ?></strong></p>
                        <a href="subasta.php?id=<?php echo $puja['id_subasta']; ?>" class="btn">Ver Subasta</a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <hr style="margin: 3rem 0;">

        <!-- Pokemons Comprados -->
        <h2 id="comprados">Pokemons Comprados (JSON)</h2>
        <?php if (isset($mensajeFlash)): ?>
            <p class='alert <?php echo $tipoMensajeFlash; ?>'><?php echo $mensajeFlash; ?></p>
        <?php elseif (isset($mensaje)): ?>
             <p class='alert alert-success'><?php echo $mensaje; ?></p>
        <?php endif; ?>
        
        <div class="card-grid">
            <?php if (empty($pokemonsComprados)): ?>
                <p>No tienes pokemons en tu inventario JSON.</p>
            <?php else: ?>
                <?php foreach ($pokemonsComprados as $key => $pk): ?>
                    <div class="card">
                        <h3><?php echo htmlspecialchars($pk['nombre']); ?></h3>
                        <p>Comprado por: <?php echo $pk['precio_compra']; ?></p>
                        <p>Fecha: <?php echo $pk['fecha_compra']; ?></p>
                        
                        <form action="vender_pokemon.php" method="POST" style="margin-top: 1rem;">
                            <input type="hidden" name="id_pokemon" value="<?php echo $pk['id_pokemon']; ?>">
                            <input type="hidden" name="nombre_pokemon" value="<?php echo $pk['nombre']; ?>">
                            <input type="hidden" name="indice_json" value="<?php echo $key; ?>">
                            <button type="submit" class="btn" style="background-color: #ff9800; color: white; width: 100%;">Subastar</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <?php if (!empty($pokemonsComprados)): ?>
            <div style="margin-top: 2rem; text-align: center;">
                <form method="POST">
                    <button type="submit" name="migrar_bd" class="btn" style="background-color: #4caf50; color: white;">Guardar Pokemons en Base de Datos</button>
                </form>
            </div>
        <?php endif; ?>

    </div>

    <script>
        function updateCountdowns() {
            const countdowns = document.querySelectorAll('.countdown');
            countdowns.forEach(el => {
                const endTime = new Date(el.getAttribute('data-endtime')).getTime();
                const now = new Date().getTime();
                const distance = endTime - now;

                if (distance < 0) {
                    el.innerHTML = "FINALIZADA";
                    el.style.color = "gray";
                    // Opcional: recargar la página si acaba de terminar para procesar ganador
                    return;
                }

                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                el.innerHTML = 
                    (hours < 10 ? "0" + hours : hours) + "h : " + 
                    (minutes < 10 ? "0" + minutes : minutes) + "m : " + 
                    (seconds < 10 ? "0" + seconds : seconds) + "s";
            });
        }

        setInterval(updateCountdowns, 1000);
        updateCountdowns(); // Initial call
    </script>
</body>
</html>
