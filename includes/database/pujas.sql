CREATE TABLE Pujas (
    id INT AUTO_INCREMENT, 
    idProducto INT, 
    idPujador VARCHAR(50), 
    precio DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (idProducto, idPujador, precio),
    FOREIGN KEY (idProducto) REFERENCES Productos(id) ON DELETE CASCADE, 
    FOREIGN KEY (idPujador) REFERENCES Usuarios(userid) ON DELETE CASCADE
);


