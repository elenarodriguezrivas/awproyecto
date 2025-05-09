CREATE TABLE Productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombreProducto VARCHAR(255) NOT NULL,
    descripcionProducto TEXT NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    categoriaProducto VARCHAR(100) NOT NULL,
    idVendedor VARCHAR(50) NOT NULL,
    rutaImagen VARCHAR(255) NOT NULL,
    estado ENUM('enventa', 'vendido') DEFAULT 'enventa',
    FOREIGN KEY (idVendedor) REFERENCES Usuarios(userid)
);

INSERT INTO Productos (nombreProducto, descripcionProducto, precio, categoriaProducto, idVendedor, rutaImagen, estado) 
VALUES 
('Laptop ACER', 'Laptop ACER con procesador Intel i5 y 8GB de RAM.', 599.99, 'Computadora', 'vendedor1', '/fotos/producto8.jpg', 'enventa'),
('Auriculares Sony', 'Auriculares inalámbricos con cancelación de ruido.', 199.99, 'Auriculares', 'vendedor2', '/fotos/producto7.jpg', 'enventa'),
('Teclado Mecánico', 'Teclado mecánico rosa.', 89.99, 'Teclado', 'vendedor3', '/fotos/producto6.jpg', 'enventa'),
('Monitor Samsung', 'Monitor Full HD de 24 pulgadas.', 149.99, 'Pantalla', 'vendedor1', '/fotos/producto2.jpg', 'enventa'),
('Ratón', 'Ratón inalámbrico color negro. ', 79.99, 'Ratón', 'vendedor3', '/fotos/producto5.jpg', 'enventa'),
('Teclado Mecánico', 'Teclado mecánico negro.', 89.99, 'Teclado', 'vendedor3', '/fotos/producto4.jpg', 'enventa');
('Impresora', 'Impresora Canon blanco.', 10.99, 'Impresora', 'vendedor3', '/fotos/producto1.jpg', 'enventa');

