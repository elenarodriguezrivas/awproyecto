CREATE TABLE Cestas (
    userId VARCHAR(50) NOT NULL,
    productoId INT NOT NULL,
    PRIMARY KEY (userId, productoId),
    FOREIGN KEY (userId) REFERENCES Usuarios(userid),
    FOREIGN KEY (productoId) REFERENCES Productos(id)
);
