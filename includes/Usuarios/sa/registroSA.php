<?php
require_once __DIR__ . '/../dao/UsuarioDAO.php';
require_once __DIR__ . '/../model/Usuario.php';

class UsuarioSA {
    private UsuarioDAO $usuarioDAO;

    public function __construct() {
        $this->usuarioDAO = new UsuarioDAO();
    }

    public function registrarUsuario(Usuario $usuario): bool {
        if ($this->usuarioDAO->existeUsuario($usuario->getUserid())) {
            return false; 
        }
        return $this->usuarioDAO->agregarUsuario($usuario);
    }
    
}

?>
