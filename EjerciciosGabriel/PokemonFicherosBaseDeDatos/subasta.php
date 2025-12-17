<?php
session_start();
require_once "Conexion.php";
require_once "funciones.php"; // Include helper functions

if (!isset($_SESSION['id_entrenador'])) {
    header("Location: login.php");
    exit;
}

$id_entrenador = $_SESSION['id_entrenador'];
$id_subasta = $_GET['id'] ?? null;
$mensaje = "";
$tipoMensaje = "";

// Check for flash messages (PRG)
$flash = getFlashMessage();
if ($flash) {
    $mensaje = $flash['texto'];
    $tipoMensaje = $flash['tipo'];
}

if (!$id_subasta) {
    header("Location: index.php");
    exit;
}

$con = new CConexion();
$pdo = $con->ConexionBD();

// Process Bid (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cantidad = $_POST['cantidad'] ?? 0;

    try {
        $pdo->beginTransaction();

        // 1. Get CURRENT auction data (locking the row)
        $stmtDatos = $pdo->prepare("SELECT s.precio_inicio, s.fecha_fin, 
                                    (SELECT cantidad FROM puja WHERE id_subasta = s.id_subasta ORDER BY cantidad DESC LIMIT 1) as puja_actual,
                                    (SELECT id_entrenador FROM puja WHERE id_subasta = s.id_subasta ORDER BY cantidad DESC LIMIT 1) as id_lider
                                    FROM subasta s
                                    WHERE s.id_subasta = :id FOR UPDATE");
        $stmtDatos->execute([':id' => $id_subasta]);
        $datosSubasta = $stmtDatos->fetch(PDO::FETCH_ASSOC);

        if (!$datosSubasta) {
            throw new Exception("Subasta no encontrada.");
        }

        if (strtotime($datosSubasta['fecha_fin']) <= time()) {
            throw new Exception("La subasta ha finalizado.");
        }

        $precio_minimo = ($datosSubasta['puja_actual']) ? $datosSubasta['puja_actual'] + 1 : $datosSubasta['precio_inicio'];

        if ($cantidad >= $precio_minimo) {
            // 2. Check CURRENT user balance
            $stmtSaldo = $pdo->prepare("SELECT saldo FROM entrenador WHERE id_entrenador = :id");
            $stmtSaldo->execute([':id' => $id_entrenador]);
            $saldo_actual_usuario = $stmtSaldo->fetchColumn();

            if ($saldo_actual_usuario >= $cantidad) {
                
                // 3. Refund previous leader (if exists)
                if ($datosSubasta['id_lider']) {
                    $stmtRefund = $pdo->prepare("UPDATE entrenador SET saldo = saldo + :cantidad WHERE id_entrenador = :id");
                    $stmtRefund->execute([
                        ':cantidad' => $datosSubasta['puja_actual'],
                        ':id' => $datosSubasta['id_lider']
                    ]);
                }

                // 4. Deduct from CURRENT user
                $stmtDeduct = $pdo->prepare("UPDATE entrenador SET saldo = saldo - :cantidad WHERE id_entrenador = :id");
                $stmtDeduct->execute([
                    ':cantidad' => $cantidad,
                    ':id' => $id_entrenador
                ]);

                // 5. Insert Bid
                $stmtPuja = $pdo->prepare("INSERT INTO puja (id_subasta, id_entrenador, cantidad) VALUES (:id_subasta, :id_entrenador, :cantidad)");
                $stmtPuja->execute([
                    ':id_subasta' => $id_subasta,
                    ':id_entrenador' => $id_entrenador,
                    ':cantidad' => $cantidad
                ]);

                $pdo->commit();
                setFlashMessage("¡Puja realizada con éxito!", "alert-success");
                
                // PRG: Redirect to prevent resubmission
                header("Location: subasta.php?id=" . $id_subasta);
                exit;

            } else {
                throw new Exception("No tienes saldo suficiente. Tu saldo es: $" . number_format($saldo_actual_usuario, 2));
            }
        } else {
            throw new Exception("La puja debe ser mayor a la actual ($" . ($precio_minimo - 1) . ")");
        }

    } catch (Exception $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        setFlashMessage("Error: " . $e->getMessage(), "alert-error");
        header("Location: subasta.php?id=" . $id_subasta);
        exit;
    }
}

// Get auction details for VIEW
$stmt = $pdo->prepare("SELECT s.*, p.nombre, p.nivel, p.descripcion,
                       (SELECT MAX(cantidad) FROM puja WHERE id_subasta = s.id_subasta) as puja_actual
                       FROM subasta s
                       JOIN pokemon p ON s.id_pokemon = p.id_pokemon
                       WHERE s.id_subasta = :id");
$stmt->execute([':id' => $id_subasta]);
$subasta = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$subasta) {
    echo "Subasta no encontrada.";
    exit;
}

$precio_minimo = ($subasta['puja_actual']) ? $subasta['puja_actual'] + 1 : $subasta['precio_inicio'];

$stmtSaldo = $pdo->prepare("SELECT saldo FROM entrenador WHERE id_entrenador = :id");
$stmtSaldo->execute([':id' => $id_entrenador]);
$saldo_actual = $stmtSaldo->fetchColumn();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subasta de <?php echo htmlspecialchars($subasta['nombre']); ?></title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <header>
        <h1>Subasta: <?php echo htmlspecialchars($subasta['nombre']); ?></h1>
        <p style="margin: 0; font-size: 0.9em;">Tu Saldo: <strong>$<?php echo number_format($saldo_actual, 2); ?></strong></p>
    </header>
    <nav>
        <a href="index.php">Volver al Panel</a>
    </nav>

    <div class="container">
        <?php if ($mensaje): ?>
            <div class="alert <?php echo $tipoMensaje; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <div class="card" style="max-width: 600px; margin: 0 auto;">
            <h2><?php echo htmlspecialchars($subasta['nombre']); ?> (Nivel <?php echo $subasta['nivel']; ?>)</h2>
            <p><strong>Descripción:</strong> <?php echo htmlspecialchars($subasta['descripcion']); ?></p>
            <hr>
            <p><strong>Precio Inicio:</strong> $<?php echo $subasta['precio_inicio']; ?></p>
            <p><strong>Puja Actual:</strong> <span style="font-size: 1.5em; color: var(--secondary-color);">$<?php echo $subasta['puja_actual'] ?? 'Sin pujas'; ?></span></p>
            <p><strong>Finaliza:</strong> <span class="countdown" data-endtime="<?php echo str_replace(' ', 'T', $subasta['fecha_fin']) . 'Z'; ?>"><?php echo $subasta['fecha_fin']; ?></span></p>

            <?php if (strtotime($subasta['fecha_fin']) > time()): ?>
                <form method="POST" style="margin-top: 2rem; background: #f9f9f9; padding: 1rem; border-radius: 8px;">
                    <div class="form-group">
                        <label for="cantidad">Tu Puja ($):</label>
                        <input type="number" name="cantidad" id="cantidad" min="<?php echo $precio_minimo; ?>" step="0.01" value="<?php echo $precio_minimo; ?>" required>
                    </div>
                    <button type="submit" class="btn" style="width: 100%">Pujar</button>
                </form>
            <?php else: ?>
                <div class="alert alert-error" style="margin-top: 1rem; text-align: center;">
                    Esta subasta ha finalizado.
                </div>
            <?php endif; ?>
        </div>
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
