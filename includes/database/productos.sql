CREATE TABLE Productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombreProducto VARCHAR(255) NOT NULL,
    descripcionProducto TEXT NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    categoriaProducto VARCHAR(100) NOT NULL,
    idVendedor VARCHAR(50) NOT NULL,
    rutaImagen VARCHAR(255) NOT NULL,
    estado VARCHAR(255) NOT NULL
);

INSERT INTO Productos (nombreProducto, descripcionProducto, precio, categoriaProducto, idVendedor, rutaImagen, estado) 
VALUES 
('Laptop HP', 'Laptop HP con procesador Intel i5 y 8GB de RAM.', 599.99, 'Computadora', 'vendedor1', 'RUTA_IMGS/catalogo/producto2.jpg', 'enventa'),
('Auriculares Sony', 'Auriculares inalámbricos con cancelación de ruido.', 199.99, 'Auriculares', 'vendedor2', 'RUTA_IMGS/catalogo/auriculares_sony.jpg', 'enventa'),
('Teclado Mecánico', 'Teclado mecánico rosa.', 89.99, 'Teclado', 'vendedor3', 'RUTA_IMGS/catalogo/producto6.jpg', 'enventa'),
('Monitor Samsung', 'Monitor Full HD de 24 pulgadas.', 149.99, 'Pantalla', 'vendedor1', 'RUTA_IMGS/catalogo/monitor_samsung.jpg', 'enventa'),
('Impresora Epson', 'Impresora multifunción con conexión Wi-Fi.', 129.99, 'Impresora', 'vendedor2', 'RUTA_IMGS/catalogo/producto1.jpg', 'enventa'),
('Altavoces JBL', 'Altavoces portátiles con sonido estéreo.', 79.99, 'Altavoces', 'vendedor3', 'RUTA_IMGS/catalogo/altavoces_jbl.jpg', 'enventa'),
('Teclado Mecánico', 'Teclado mecánico negro.', 89.99, 'Teclado', 'vendedor3', 'RUTA_IMGS/catalogo/producto4.jpg', 'enventa');
