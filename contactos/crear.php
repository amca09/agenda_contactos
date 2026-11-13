<?php

$redireccion_login =
    "../auth/iniciar_sesion.php";

require_once "../includes/proteger.php";
require_once "../config/database.php";

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = trim($_POST["nombre"]);
    $telefono = trim($_POST["telefono"]);
    $correo = trim($_POST["correo"]);
    $ciudad = trim($_POST["ciudad"]);

    $id_usuario =
        $_SESSION["usuario_id"];

    if (
        $nombre == "" ||
        $telefono == "" ||
        $correo == "" ||
        $ciudad == ""
    ) {

        $mensaje =
            "Todos los campos son obligatorios.";

    } elseif (
        !filter_var(
            $correo,
            FILTER_VALIDATE_EMAIL
        )
    ) {

        $mensaje =
            "Ingrese un correo electrónico válido.";

    } else {

        $insertar = $conexion->prepare(
            "INSERT INTO contactos
            (id_usuario, nombre, telefono, correo, ciudad)
            VALUES (?, ?, ?, ?, ?)"
        );

        $insertar->bind_param(
            "issss",
            $id_usuario,
            $nombre,
            $telefono,
            $correo,
            $ciudad
        );

        if ($insertar->execute()) {

            header(
                "Location: ../panel.php"
            );

            exit;

        } else {

            $mensaje =
                "Ocurrió un error al guardar el contacto.";
        }
    }
}

?>

<!DOCTYPE html>

<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Crear contacto</title>

    <link
        rel="stylesheet"
        href="../css/estilos.css"
    >

</head>

<body>

<div class="contenedor">

    <h1>Crear contacto</h1>

    <?php

    if ($mensaje != "") {
        echo '<p class="mensaje">'
            . $mensaje .
            '</p>';
    }

    ?>

    <form method="POST">

        <label>Nombre:</label>

        <input
            type="text"
            name="nombre"
            required
        >

        <br><br>

        <label>Teléfono:</label>

        <input
            type="text"
            name="telefono"
            required
        >

        <br><br>

        <label>Correo:</label>

        <input
            type="email"
            name="correo"
            required
        >

        <br><br>

        <label>Ciudad:</label>

        <input
            type="text"
            name="ciudad"
            required
        >

        <br><br>

        <button type="submit">
            Guardar contacto
        </button>

    </form>

    <p class="centrado">

        <a
            class="boton boton-salir"
            href="../panel.php"
        >
            Volver al panel
        </a>

    </p>

</div>

</body>

</html>