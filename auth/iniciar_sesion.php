<?php

session_start();

require_once "../config/database.php";

$mensaje = "";

// Si ya inició sesión, enviamos al panel
if (isset($_SESSION["usuario_id"])) {

    header("Location: ../panel.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $correo = trim($_POST["correo"]);
    $contrasena = $_POST["contrasena"];

    if ($correo == "" || $contrasena == "") {

        $mensaje = "Complete todos los campos.";

    } else {

        // Buscamos al usuario por su correo
        $consulta = $conexion->prepare(
            "SELECT id, nombre, correo, password
             FROM usuarios
             WHERE correo = ?"
        );

        $consulta->bind_param("s", $correo);

        $consulta->execute();

        $resultado = $consulta->get_result();

        if ($resultado->num_rows == 1) {

            $usuario = $resultado->fetch_assoc();

            // Comprobamos la contraseña
            if (
                password_verify(
                    $contrasena,
                    $usuario["password"]
                )
            ) {

                // Guardamos los datos del usuario en la sesión
                $_SESSION["usuario_id"] = $usuario["id"];
                $_SESSION["usuario_nombre"] = $usuario["nombre"];
                $_SESSION["usuario_correo"] = $usuario["correo"];

                header("Location: ../panel.php");
                exit;

            } else {

                $mensaje = "Correo o contraseña incorrectos.";
            }

        } else {

            $mensaje = "Correo o contraseña incorrectos.";
        }
    }
}

?>

<!DOCTYPE html>

<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Iniciar sesión</title>

    <link rel="stylesheet" href="../css/estilos.css">

</head>

<body>

<div class="contenedor">

    <h1>Iniciar sesión</h1>

    <?php

    if ($mensaje != "") {
        echo '<p class="mensaje">' . $mensaje . '</p>';
    }

    ?>

    <form method="POST">

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
            Iniciar sesión
        </button>

    </form>

    <p class="centrado">

        ¿No tienes una cuenta?

        <a href="registro.php">
            Registrarse
        </a>

    </p>

</div>

</body>

</html>