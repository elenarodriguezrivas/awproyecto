CREATE TABLE Pujas (
    idProducto INT, 
    idPujador VARCHAR(50), 
    precio DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (idProducto, idPujador, precio), --no permite que el mismo usuario puje por el mismpo producto con el mismo precio
    FOREIGN KEY (idProducto) REFERENCES Productos(id) ON DELETE CASCADE, 
    FOREIGN KEY (idPujador) REFERENCES Usuarios(userid) ON DELETE CASCADE
);
