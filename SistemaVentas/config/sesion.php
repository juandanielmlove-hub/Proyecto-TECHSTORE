
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function verificarSesion() {
    if (!isset($_SESSION['usuario_id'])) {
        header("Location: /SistemaVentas/index.php?ruta=login");
        exit;
    }
}

function obtenerNombreUsuario() {
    return $_SESSION['nombre'] ?? 'Invitado';
}
