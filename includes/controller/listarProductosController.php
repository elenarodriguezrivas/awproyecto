<?php
require_once __DIR__ . '/../Usuarios/sa/listarProductosSA.php';
session_start();

class ListarProductosController {
    private $listarProductoSA;

    public function __construct() {
        $this->listarProductoSA = new ListarProductosSA();
    }

    public function listarProductos() {
        $arrayProductos = $this->listarProductoSA->listarProductos();
    }
}

for($i = 0; count($arrayProductos); $i++){
    $producto = $arrayProductos[$i];
    $productos[] = [
        "nombre" => $ptoducto->getNombreProducto(),
        "descripcion" => $producto->getDescripcionProducto()
    ]
}
echo json_encode([
    "nombre" => $user->getNombre(),
    "apellidos" => $user->getApellidos(),
    "edad" => $user->getEdad(),
    "correo" => $correoPixelado
]);
?>
