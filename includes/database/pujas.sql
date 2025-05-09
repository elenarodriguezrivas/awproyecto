CREATE TABLE Pujas (
    idSubasta INT, 
    idPujador VARCHAR(50), 
    precio DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (idSubasta, idPujador, precio), 
    FOREIGN KEY (idSubasta) REFERENCES Subastas(id),
    FOREIGN KEY (idPujador) REFERENCES Usuarios(userid)
);
