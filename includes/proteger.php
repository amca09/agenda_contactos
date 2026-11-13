<?php

// Iniciamos la sesión si todavía no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Si no existe un usuario conectado,
// lo enviamos al inicio de sesión
if (!isset($_SESSION["usuario_id"])) {

    header("Location: " . $redireccion_login);
    exit;
}

?>