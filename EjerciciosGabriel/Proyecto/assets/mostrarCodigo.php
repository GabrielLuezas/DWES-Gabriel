<?php
// ==============================
// Mostrar código con estilo Monokai
// ==============================

// Comprobamos si se pasó el archivo
if (!isset($_GET['archivo'])) {
    echo "<p style='font-family:monospace;color:orange'>No se especificó ningún archivo.</p>";
    exit;
}

$archivo = $_GET['archivo'];
$archivo = str_replace(['..', './', '\\'], '', $archivo); // Sanitización

// Comprobamos el tipo (sesiones o cookies), por defecto sesiones
$tipo = isset($_GET['tipo']) && $_GET['tipo'] === 'cookies' ? 'cookies' : 'sesiones';

// Construimos la ruta real según el tipo
$ruta_real = realpath(__DIR__ . "/../$tipo/" . $archivo);

if (!$ruta_real || !file_exists($ruta_real) || !is_file($ruta_real)) {
    echo "<p style='color:red;font-family:monospace'>⚠️ Archivo no encontrado o inválido: <b>$archivo</b></p>";
    exit;
}

// --- Configuración de colores Monokai ---
ini_set('highlight.comment', '#75715e; font-style:italic');
ini_set('highlight.default', '#f8f8f2');
ini_set('highlight.keyword', '#66d9ef; font-weight:bold');
ini_set('highlight.string', '#e6db74');
ini_set('highlight.html', '#f92672');
ini_set('highlight.identifier', '#fd971f');
ini_set('highlight.bg', '#272822');

// --- HTML de presentación ---
echo <<<HTML
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Vista de Código</title>
    <link rel="stylesheet" href="../assets/monokai.css">
    <style>
        :root {
            --bg: #272822; 
            --accent: #66d9ef; 
        }
        body {
            margin: 0;
            padding: 20px;
            background: var(--bg);
            color: #f8f8f2;
            font-family: 'Fira Code', monospace;
        }
        pre {
            font-size: 15px;
            line-height: 1.5;
            overflow-x: auto;
        }
    </style>
</head>
<body>
HTML;

// Mostramos el código resaltado
echo "<pre>";
highlight_file($ruta_real);
echo "</pre>";

echo <<<HTML
</body>
</html>
HTML;
?>
