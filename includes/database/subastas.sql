CREATE TABLE Subastas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idProducto INT UNIQUE NOT NULL,
    fechaSubasta DATE NOT NULL,
    estado ENUM('en_subasta', 'vendido', 'anulada') DEFAULT 'en_subasta',
    precio DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (idProducto) REFERENCES Productos(id) ON DELETE CASCADE
);
