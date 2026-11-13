<?php

// Datos de conexión a la base de datos
$servidor = "localhost";
$usuario = "root";
$contrasena_bd = "";
$base_datos = "agenda_contactos";

// Creamos la conexión
$conexion = new mysqli(
    $servidor,
    $usuario,
    $contrasena_bd,
    $base_datos
);

// Comprobamos si existe un error
if ($conexion->connect_error) {
    die("Error de conexión a la base de datos.");
}

// Permitimos correctamente caracteres como ñ y tildes
$conexion->set_charset("utf8mb4");

?>