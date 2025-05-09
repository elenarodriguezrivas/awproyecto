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
) AUTO_INCREMENT = 10000;

INSERT INTO `subastas` (`id`, `nombreSubasta`, `descripcionSubasta`, `precio_original`, `precio_actual`, `idVendedor`, `rutaImagen`, `estado`, `fechaSubasta`, `horaSubasta`) VALUES
(10000, 'Portátil ProArt', 'Ordenador Portátil ', 1000.00, 1300.00, 'vendedor2', '/fotos/subasta1.jpg', 'en_subasta', '2025-05-12', '08:31:00'),
(10001, 'Computadora de escritorio de Microsoft', 'Microsoft modelo de escritorio', 2000.00, 2050.00, 'vendedor2', '/fotos/subasta2.jpg', 'en_subasta', '2025-05-09', '10:33:00'),
(10002, 'Apple Iphone 14 Pro', 'Modelo camara ampliada', 2300.00, 2501.00, 'vendedor3', '/fotos/subasta3.jpg', 'en_subasta', '2025-05-10', '14:35:00'),
(10003, 'Móvil Samsung Galaxy A13', '64 Gb negro', 800.00, 1003.00, 'vendedor3', '/fotos/subasta4.jpg', 'en_subasta', '2025-05-14', '03:36:00'),
(10004, 'Lucha Videojuego WWE 20', 'para PlayStation4', 30.00, 51.00, 'vendedor3', '/fotos/subasta5.jpg', 'en_subasta', '2025-05-29', '16:42:00'),
(10005, 'Dragon Ball Xenoverse 2', 'para PlayStation4', 35.00, 35.00, 'vendedor1', '/fotos/subasta6.jpg', 'en_subasta', '2025-05-24', '16:44:00');
