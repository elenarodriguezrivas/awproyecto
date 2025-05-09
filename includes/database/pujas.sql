CREATE TABLE Pujas (
    idSubasta INT, 
    idPujador VARCHAR(50), 
    precio DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (idSubasta, idPujador, precio), 
    FOREIGN KEY (idSubasta) REFERENCES Subastas(id),
    FOREIGN KEY (idPujador) REFERENCES Usuarios(userid)
);

INSERT INTO `pujas` (`idSubasta`, `idPujador`, `precio`) VALUES
(10000, 'elena2', 1002.00),
(10001, 'elena2', 2010.00),
(10002, 'elena2', 2400.00),
(10003, 'elena2', 900.00),
(10004, 'elena2', 40.00),
(10000, 'usuarioA', 1010.00),
(10001, 'usuarioA', 2030.00),
(10002, 'usuarioA', 2500.00),
(10003, 'usuarioA', 1000.00),
(10004, 'usuarioA', 50.00),
(10000, 'usuarioB', 1200.00),
(10001, 'usuarioB', 2050.00),
(10002, 'usuarioB', 2501.00),
(10003, 'usuarioB', 1003.00),
(10004, 'usuarioB', 51.00),
(10000, 'vendedor1', 1300.00);
