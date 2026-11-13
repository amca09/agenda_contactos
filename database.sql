CREATE DATABASE IF NOT EXISTS agenda_contactos
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE agenda_contactos;


CREATE TABLE IF NOT EXISTS usuarios (

    id INT(11)
    AUTO_INCREMENT
    PRIMARY KEY,

    nombre VARCHAR(100)
    NOT NULL,

    correo VARCHAR(150)
    NOT NULL
    UNIQUE,

    password VARCHAR(255)
    NOT NULL,

    fecha_registro TIMESTAMP
    DEFAULT CURRENT_TIMESTAMP

);


CREATE TABLE IF NOT EXISTS contactos (

    id INT(11)
    AUTO_INCREMENT
    PRIMARY KEY,

    id_usuario INT(11)
    NOT NULL,

    nombre VARCHAR(100)
    NOT NULL,

    telefono VARCHAR(20)
    NOT NULL,

    correo VARCHAR(150)
    NOT NULL,

    ciudad VARCHAR(100)
    NOT NULL,

    FOREIGN KEY (id_usuario)
        REFERENCES usuarios(id)
        ON DELETE CASCADE
        ON UPDATE RESTRICT

);