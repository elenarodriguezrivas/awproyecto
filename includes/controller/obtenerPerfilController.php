<?php
require_once __DIR__ . '/../Usuarios/sa/perfilSA.php';

class ObtenerPerfilController {
    private $perfilSA;

    public function __construct() {
        $this->perfilSA = new PerfilSA();
    }

    public function mostrarPerfil($idUsuario) {
        $usuario = $this->perfilSA->obtenerUsuarioPorId($idUsuario);
        if ($usuario) {
            // Pasar los datos del usuario a la vista
            require_once __DIR__ . '/../../view/perfil_pantalla.php';
        } else {
            echo "Usuario no encontrado.";
        }
    }
}

// Ejemplo de uso
$controller = new ObtenerPerfilController();
$controller->mostrarPerfil($_SESSION['userid']);
?>