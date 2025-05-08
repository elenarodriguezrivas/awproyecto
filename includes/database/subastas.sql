CREATE TABLE Subastas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombreSubasta VARCHAR(255) NOT NULL,
    descripcionSubasta TEXT NOT NULL,
    precio_original DECIMAL(10,2) NOT NULL,
    precio_actual  DECIMAL(10,2) NOT NULL,
    idVendedor VARCHAR(50) NOT NULL,
    rutaImagen VARCHAR(255) NOT NULL,
    estado ENUM('en_subasta','anulada','finalizada') DEFAULT 'en_subasta',
    fechaSubasta DATE NOT NULL,
    horaSubasta TIME NOT NULL,
    FOREIGN KEY (idVendedor) REFERENCES Usuarios(userid)
);