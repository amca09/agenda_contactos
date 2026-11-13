<?php

require_once "../config/database.php";

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = trim($_POST["nombre"]);
    $correo = trim($_POST["correo"]);
    $contrasena = $_POST["contrasena"];

    // Validación del lado del servidor
    if ($nombre == "" || $correo == "" || $contrasena == "") {

        $mensaje = "Todos los campos son obligatorios.";

    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {

        $mensaje = "Ingrese un correo electrónico válido.";

    } else {

        // Comprobamos si el correo ya existe
        $consulta = $conexion->prepare(
            "SELECT id FROM usuarios WHERE correo = ?"
        );

        $consulta->bind_param("s", $correo);

        $consulta->execute();

        $resultado = $consulta->get_result();

        if ($resultado->num_rows > 0) {

            $mensaje = "Ese correo ya está registrado.";

        } else {

            // Protegemos la contraseña
            $contrasena_segura = password_hash(
                $contrasena,
                PASSWORD_DEFAULT
            );

            // Guardamos al usuario
            // La columna se llama password porque así está
            // definida en la actividad y en la base de datos
            $insertar = $conexion->prepare(
                "INSERT INTO usuarios
                (nombre, correo, password)
                VALUES (?, ?, ?)"
            );

            $insertar->bind_param(
                "sss",
                $nombre,
                $correo,
                $contrasena_segura
            );

            if ($insertar->execute()) {

                $mensaje = "Usuario registrado correctamente.";

            } else {

                $mensaje = "Ocurrió un error al registrar el usuario.";
            }
        }
    }
}

?>

<!DOCTYPE html>

<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Registro de usuario</title>

    <link rel="stylesheet" href="../css/estilos.css">

</head>

<body>

<div class="contenedor">

    <h1>Registro de usuario</h1>

    <?php

    if ($mensaje != "") {
        echo '<p class="mensaje">' . $mensaje . '</p>';
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

        <label>Correo:</label>

        <input
            type="email"
            name="correo"
            required
        >

        <br><br>

        <label>Contraseña:</label>

        <input
            type="password"
            name="contrasena"
            required
        >

        <br><br>

        <button type="submit">
            Registrarse
        </button>

    </form>

    <p class="centrado">

        ¿Ya tienes una cuenta?

        <a href="iniciar_sesion.php">
            Iniciar sesión
        </a>

    </p>

</div>

</body>

</html>