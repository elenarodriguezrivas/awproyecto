<?php
require_once __DIR__ . '/../dao/ProductoDAO.php';
require_once __DIR__ . '/../model/Anuncio.php';

class ProductoSA {
    private ProductoDAO $productoDAO;

    public function __construct() {
        $this->productoDAO = new ProductoDAO();
    }

    //Agrega un producto después de validarlo.

    public function agregarProducto(array $datos): string {
        if (!$this->validarDatos($datos)) {
            return "Datos inválidos.";
        }

        $producto = new Anuncio(
            $datos['nombreProducto'],
            $datos['descripcionProducto'],
            $datos['precio'],
            $datos['vendedor'],
            $datos['comprador'] ?? null
        );

        return $this->productoDAO->agregarProducto($producto) ? "Producto agregado con éxito." : "Error al agregar producto.";
    }

    public function listarProductos(): array {
        return $this->productoDAO->listarProductos();
    }

    public function eliminarProducto(int $id): string {
        return $this->productoDAO->eliminarProducto($id) ? "Producto eliminado." : "Error al eliminar producto.";
    }

    private function validarDatos(array $datos): bool {
        return isset($datos['nombreProducto'], $datos['descripcionProducto'], $datos['precio'], $datos['vendedor']) &&
               is_numeric($datos['precio']) && $datos['precio'] > 0;
    }
}
?>
