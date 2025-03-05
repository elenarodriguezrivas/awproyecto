<?php
require_once __DIR__ . '/../dao/ProductoDAO.php';
require_once __DIR__ . '/../model/Anuncio.php';

class ProductoSA { //llama a ProductoDAO para que conecte con la base de datos
    private ProductoDAO $productoDAO;

    public function __construct() {
        $this->productoDAO = new ProductoDAO();
    }

    public function agregarProducto(array $datos): string {
        if ($this->validarDatos($datos)) {
            $producto = new Producto(
                $datos['id'],
                $datos['nombreProducto'],
                $datos['descripcionProducto'],
                $datos['precio'],
                $datos['categoriaProducto'],  // Asegúrate de que el índice sea correcto
                $datos['fechaRegistroProducto'], 
                $datos['idVendedor']
            );
            
            return $this->productoDAO->agregarProducto($producto) ? "Producto agregado con éxito." : "Error al agregar producto.";
        } else {
            return "Datos inválidos.";
        }

        return $this->productoDAO->agregarProducto($producto) ? "Producto agregado con éxito." : "Error al agregar producto.";
    }

    public function listarProductos(): array {
        return $this->productoDAO->listarProductos();
    }

    public function eliminarProducto(string $id): string {
        return $this->productoDAO->eliminarProducto($id) ? "Producto eliminado." : "Error al eliminar producto.";
    }

    public function obtenerProductoPorId(string $id): ?Producto {
        return $this->productoDAO->obtenerProductoPorId($id);
    }

    public function buscarProductosPorCategoria(string $categoria): array{
        return $this->productoDAO->buscarProductosPorCategoria($categoria);
    }

    private function validarDatos(array $datos): bool {
        return isset($datos['nombreProducto'], $datos['descripcionProducto'], $datos['precio'], $datos['vendedor']) &&
               is_numeric($datos['precio']) && $datos['precio'] > 0;
    }
}
?>
