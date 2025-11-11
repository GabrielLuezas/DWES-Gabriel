<?php
// ==============================
// Mostrar código con estilo Monokai
// ==============================

// Seguridad: prevenir que se accedan archivos fuera del proyecto
if (isset($_GET['archivo'])) {
    $archivo = $_GET['archivo'];
    // Sanitización de ruta para prevenir ataques de Directory Traversal
    $archivo = str_replace(['..', './', '\\'], '', $archivo); 

    // Construye la ruta real del archivo (Asume que busca dentro de /sesiones/).
    $ruta_real = realpath(__DIR__ . '/../sesiones/' . $archivo);

    // Comprobación de existencia y validez
    if ($ruta_real && file_exists($ruta_real) && is_file($ruta_real)) {
        
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
                padding: 20px; /* Asegura un margen alrededor del código */
                background: var(--bg); 
                color: #f8f8f2;
                font-family: 'Fira Code', monospace;
            }
            /* ¡ESTILOS DEL PRE ELIMINADOS! El código se integrará al fondo del body. */
            pre {
                font-size: 15px;
                line-height: 1.5;
                overflow-x: auto;
                /* El padding y background del body ahora controlan el aspecto */
            }
        </style>
    </head>
    <body>
HTML;

        // Muestra el código resaltado
        echo "<pre>";
        highlight_file($ruta_real);
        echo "</pre>";

        echo <<<HTML
    </body>
    </html>
HTML;
        
    } else {
        // Mensaje de error si no se encuentra el archivo
        echo "<p style='color:red;font-family:monospace'>⚠️ Archivo no encontrado o inválido: <b>$archivo</b></p>";
    }
} else {
    // Mensaje si no se pasa el parámetro 'archivo' en la URL
    echo "<p style='font-family:monospace;color:orange'>No se especificó ningún archivo.</p>";
}
?>