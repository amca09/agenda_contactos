<?php

$redireccion_login = "auth/iniciar_sesion.php";

require_once "includes/proteger.php";
require_once "config/database.php";

// Obtenemos el id del usuario conectado
$id_usuario = $_SESSION["usuario_id"];

// Buscamos únicamente los contactos de ese usuario
$consulta = $conexion->prepare(
    "SELECT id, nombre, telefono, correo, ciudad
     FROM contactos
     WHERE id_usuario = ?
     ORDER BY nombre ASC"
);

$consulta->bind_param(
    "i",
    $id_usuario
);

$consulta->execute();

$resultado = $consulta->get_result();

?>

<!DOCTYPE html>

<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Agenda de contactos</title>

    <link rel="stylesheet" href="css/estilos.css">

</head>

<body>

<div class="contenedor">

    <h1>Agenda Personal de Contactos</h1>

    <div class="informacion-usuario">

        <p>
            Bienvenido:
            <strong>
                <?php
                echo htmlspecialchars(
                    $_SESSION["usuario_nombre"]
                );
                ?>
            </strong>
        </p>

        <p>
            Correo:
            <?php
            echo htmlspecialchars(
                $_SESSION["usuario_correo"]
            );
            ?>
        </p>

    </div>

    <div class="enlaces">

        <a
            class="boton"
            href="contactos/crear.php"
        >
            Crear contacto
        </a>

        <a
            class="boton boton-salir"
            href="auth/cerrar_sesion.php"
        >
            Cerrar sesión
        </a>

    </div>

    <hr>

    <h2>Mis contactos</h2>

    <?php

    if ($resultado->num_rows == 0) {

        echo '<p class="centrado">
                No tienes contactos registrados.
              </p>';

    } else {

    ?>

        <div class="tabla-contenedor">

            <table>

                <tr>

                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th>Ciudad</th>
                    <th>Acciones</th>

                </tr>

                <?php

                while (
                    $contacto = $resultado->fetch_assoc()
                ) {

                ?>

                    <tr>

                        <td>
                            <?php
                            echo htmlspecialchars(
                                $contacto["nombre"]
                            );
                            ?>
                        </td>

                        <td>
                            <?php
                            echo htmlspecialchars(
                                $contacto["telefono"]
                            );
                            ?>
                        </td>

                        <td>
                            <?php
                            echo htmlspecialchars(
                                $contacto["correo"]
                            );
                            ?>
                        </td>

                        <td>
                            <?php
                            echo htmlspecialchars(
                                $contacto["ciudad"]
                            );
                            ?>
                        </td>

                        <td>

                            <div class="acciones">

                                <a
                                    class="boton boton-editar"
                                    href="contactos/editar.php?id=<?php echo $contacto["id"]; ?>"
                                >
                                    Editar
                                </a>

                                <a
                                    class="boton boton-eliminar"
                                    href="contactos/eliminar.php?id=<?php echo $contacto["id"]; ?>"
                                >
                                    Eliminar
                                </a>

                            </div>

                        </td>

                    </tr>

                <?php } ?>

            </table>

        </div>

    <?php } ?>

</div>

</body>

</html>