CREATE TABLE Usuarios (
    userid VARCHAR(50) PRIMARY KEY,
    contrasena VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    nombre VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    edad INT NOT NULL,
    rol VARCHAR(50) NOT NULL
);