<?php
if (isset($_GET['archivo'])) {
    $archivo = $_GET['archivo'];
    if (file_exists($archivo)) {
        echo "<pre style='text-align:left; background:#272822; color:#f8f8f2; padding:15px; overflow:auto; border-radius:8px;'>";
        highlight_file($archivo);
        echo "</pre>";
    } else {
        echo "<p>Archivo no encontrado: $archivo</p>";
    }
} else {
    echo "<p>No se especificó ningún archivo.</p>";
}
?>
