CREATE TABLE Ventas (
    producto_id INT NOT NULL,      -- ID del producto
    vendedor_id VARCHAR(50) NOT NULL,      -- ID del vendedor (usuario que realiza la venta)
    comprador_id VARCHAR(50) NOT NULL,     -- ID del comprador (usuario que compra)
    PRIMARY KEY (producto_id, vendedor_id, comprador_id),  -- Combinación única de las tres claves foráneas
    FOREIGN KEY (producto_id) REFERENCES Productos(id),    -- Relación con la tabla Productos
    FOREIGN KEY (vendedor_id) REFERENCES Usuarios(userid),     -- Relación con la tabla Usuarios (vendedor)
    FOREIGN KEY (comprador_id) REFERENCES Usuarios(userid)      -- Relación con la tabla Usuarios (comprador)
);