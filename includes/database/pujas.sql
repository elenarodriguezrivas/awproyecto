CREATE TABLE Pujas (
    idSubasta INT, 
    idPujador VARCHAR(50), 
    precio DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (idSubasta, idPujador, precio) --no permite que el mismo usuario puje por el mismpo producto con el mismo precio
);
