# Agenda Personal de Contactos

Proyecto desarrollado para la asignatura Desarrollo Web de la UTPL.

## Descripción

Aplicación web desarrollada en PHP y MySQL que permite registrar usuarios y administrar una agenda personal de contactos.

Cada usuario únicamente puede consultar, crear, editar y eliminar sus propios contactos.

## Tecnologías utilizadas

PHP

MySQL / MariaDB

HTML5

CSS

XAMPP

phpMyAdmin

## Funcionalidades

Registro de usuarios.

Inicio de sesión.

Cierre de sesión.

Protección de contraseñas.

Manejo de sesiones.

Registro de contactos.

Listado de contactos.

Edición de contactos.

Eliminación de contactos.

Restricción de acceso por usuario.

## Seguridad

Las contraseñas se protegen utilizando password_hash().

Para verificar las contraseñas se utiliza password_verify().

Las páginas privadas verifican que exista una sesión activa.

Las consultas verifican que los contactos pertenezcan al usuario autenticado.

Esto impide que un usuario pueda acceder a los contactos de otra persona modificando manualmente el identificador de la URL.

## Requisitos

XAMPP.

Apache.

MySQL o MariaDB.

Navegador web.

## Instalación

Copiar la carpeta del proyecto dentro de:


Iniciar Apache y MySQL desde XAMPP.

Importar el archivo database.sql mediante phpMyAdmin.

Abrir en el navegador:

http://localhost/agenda_contactos