<?php
// funciones.php

function setFlashMessage($mensaje, $tipo = 'alert-info') {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['flash_message'] = [
        'texto' => $mensaje,
        'tipo' => $tipo
    ];
}

function getFlashMessage() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (isset($_SESSION['flash_message'])) {
        $msg = $_SESSION['flash_message'];
        unset($_SESSION['flash_message']);
        return $msg;
    }
    return null;
}
?>
