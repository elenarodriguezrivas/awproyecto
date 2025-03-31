CREATE TABLE Productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombreProducto VARCHAR(255) NOT NULL,
    descripcionProducto TEXT NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    categoriaProducto VARCHAR(100) NOT NULL,
    idVendedor INT NOT NULL,
    rutaImagen VARCHAR(255) NOT NULL,
    estado VARCHAR(255) NOT NULL
);
