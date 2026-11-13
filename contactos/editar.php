<?php

$redireccion_login =
    "../auth/iniciar_sesion.php";

require_once "../includes/proteger.php";
require_once "../config/database.php";

$id_usuario =
    $_SESSION["usuario_id"];

$mensaje = "";

// Comprobamos que exista un id
if (!isset($_GET["id"])) {

    die("Contacto no encontrado.");
}

$id_contacto =
    (int) $_GET["id"];

// Buscamos el contacto y comprobamos
// que pertenezca al usuario conectado
$consulta = $conexion->prepare(
    "SELECT id, nombre, telefono, correo, ciudad
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
        "No tienes permiso para editar este contacto."
    );
}

$contacto =
    $resultado->fetch_assoc();

if (
    $_SERVER["REQUEST_METHOD"] == "POST"
) {

    $nombre =
        trim($_POST["nombre"]);

    $telefono =
        trim($_POST["telefono"]);

    $correo =
        trim($_POST["correo"]);

    $ciudad =
        trim($_POST["ciudad"]);

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

        $actualizar =
            $conexion->prepare(
                "UPDATE contactos
                 SET nombre = ?,
                     telefono = ?,
                     correo = ?,
                     ciudad = ?
                 WHERE id = ?
                 AND id_usuario = ?"
            );

        $actualizar->bind_param(
            "ssssii",
            $nombre,
            $telefono,
            $correo,
            $ciudad,
            $id_contacto,
            $id_usuario
        );

        if (
            $actualizar->execute()
        ) {

            header(
                "Location: ../panel.php"
            );

            exit;

        } else {

            $mensaje =
                "Ocurrió un error al actualizar el contacto.";
        }
    }
}

?>

<!DOCTYPE html>

<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Editar contacto</title>

    <link
        rel="stylesheet"
        href="../css/estilos.css"
    >

</head>

<body>

<div class="contenedor">

    <h1>Editar contacto</h1>

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
            value="<?php echo htmlspecialchars($contacto["nombre"]); ?>"
            required
        >

        <br><br>

        <label>Teléfono:</label>

        <input
            type="text"
            name="telefono"
            value="<?php echo htmlspecialchars($contacto["telefono"]); ?>"
            required
        >

        <br><br>

        <label>Correo:</label>

        <input
            type="email"
            name="correo"
            value="<?php echo htmlspecialchars($contacto["correo"]); ?>"
            required
        >

        <br><br>

        <label>Ciudad:</label>

        <input
            type="text"
            name="ciudad"
            value="<?php echo htmlspecialchars($contacto["ciudad"]); ?>"
            required
        >

        <br><br>

        <button type="submit">
            Actualizar contacto
        </button>

    </form>

    <p class="centrado">

        <a
            class="boton boton-salir"
            href="../panel.php"
        >
            Cancelar
        </a>

    </p>

</div>

</body>

</html>