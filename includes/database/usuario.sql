CREATE TABLE Usuarios (
    userid VARCHAR(50) PRIMARY KEY,
    contrasena VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    nombre VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    edad INT NOT NULL,
    rol VARCHAR(50) NOT NULL
);

INSERT INTO Usuarios (userid, contrasena, email, nombre, apellidos, edad, rol) 
VALUES
('vendedor1', '$2y$10$XrvoiRarSpb/TB/YldgM4eoQUO.8iW7Xs4MB4QX5Zzd2GC89Gvwqe', 'vendedor1@example.com', 'Juan', 'Pérez', 30, 'usuario'),
('vendedor2', '$2y$10$92WPTjQkORMGAoGlu5FvFuUGescNf0ZUL.VvbqGTyxEvSwc7L5fpu', 'vendedor2@example.com', 'María', 'Gómez', 28, 'usuario'),
('vendedor3', '$2y$10$2qxmXLlBu.ZuSyb7iPamwuGLa7l24QesyPJ91SbpJVR/F0QIW7fgK', 'vendedor3@example.com', 'Carlos', 'López', 35, 'usuario');