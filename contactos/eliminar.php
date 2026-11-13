<?php

$redireccion_login =
    "../auth/iniciar_sesion.php";

require_once "../includes/proteger.php";
require_once "../config/database.php";

$id_usuario =
    $_SESSION["usuario_id"];

if (!isset($_GET["id"])) {

    die("Contacto no encontrado.");
}

$id_contacto =
    (int) $_GET["id"];

// Comprobamos que el contacto pertenezca
// al usuario que tiene la sesión abierta
$consulta = $conexion->prepare(
    "SELECT id, nombre
     FROM contactos
     WHERE id = ?
     AND id_usuario = ?"
);

$consulta->bind_param(
    "ii",
    $id_contacto,
    $id_usuario
);

$consulta->execute();

$resultado =
    $consulta->get_result();

if ($resultado->num_rows != 1) {

    die(
        "No tienes permiso para eliminar este contacto."
    );
}

$contacto =
    $resultado->fetch_assoc();

if (
    $_SERVER["REQUEST_METHOD"] == "POST"
) {

    $eliminar = $conexion->prepare(
        "DELETE FROM contactos
         WHERE id = ?
         AND id_usuario = ?"
    );

    $eliminar->bind_param(
        "ii",
        $id_contacto,
        $id_usuario
    );

    $eliminar->execute();

    header(
        "Location: ../panel.php"
    );

    exit;
}

?>

<!DOCTYPE html>

<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Eliminar contacto</title>

    <link
        rel="stylesheet"
        href="../css/estilos.css"
    >

</head>

<body>

<div class="contenedor">

    <h1>Eliminar contacto</h1>

    <p class="centrado">

        ¿Está seguro de que desea eliminar a

        <strong>
            <?php
            echo htmlspecialchars(
                $contacto["nombre"]
            );
            ?>
        </strong>?

    </p>

    <form method="POST">

        <button
            class="boton-eliminar"
            type="submit"
        >
            Sí, eliminar
        </button>

    </form>

    <p class="centrado">

        <a
            class="boton boton-salir"
            href="../panel.php"
        >
            No, cancelar
        </a>

    </p>

</div>

</body>

</html>