<?php

session_start();

// Eliminamos todos los datos de la sesión
session_destroy();

// Regresamos al inicio de sesión
header("Location: iniciar_sesion.php");

exit;

?>