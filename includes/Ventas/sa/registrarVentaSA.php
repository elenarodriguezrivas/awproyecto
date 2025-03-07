<?php
require_once __DIR__ . '/../dao/VentaDAO.php';
require_once __DIR__ . '/../model/Venta.php';

class RegistroSA {
    private $ventaDAO;

    public function __construct() {
        $this->ventaDAO = new UsuarioDAO();
    }

    public function registrarUsuario(Venta $venta): bool {
        return $this->ventaDAO->agregarUsuario($venta);
    }
    
}

?>
