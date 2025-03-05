<?php
require_once __DIR__ . '/../../database/Connection.php';
require_once __DIR__ . '/../model/Producto.php';

class ProductoDAO extends DB { /*extiende de la base*/
    
    public function agregarProducto(Producto $producto): bool { /*Agregar un nuevo producto*/
        try {
            $sql = "INSERT INTO productos (id, nombreProducto, descripcionProducto, precio, categoriaProducto, fechaRegistroProducto, idVendedor) 
                    VALUES (:id, :nombre, :descripcion, :precio, :categoria, :fecha, : idVendedor)";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $producto->getId(), PDO::PARAM_STR);
            $stmt->bindParam(':nombre', $producto->getNombreProducto(), PDO::PARAM_STR);
            $stmt->bindParam(':descripcion', $producto->getDescripcionProducto(), PDO::PARAM_STR);
            $stmt->bindParam(':precio', $producto->getPrecio(), PDO::PARAM_STR);
            $stmt->bindParam(':categoria', $producto->getcategoriaProducto(), PDO::PARAM_STR);
            $stmt->bindParam(':fecha', $producto->getfechaRegistroProducto(), PDO::PARAM_STR);
            $stmt->bindParam(':idVendedor', $producto->getIdVendedor(), PDO::PARAM_STR);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al agregar producto: " . $e->getMessage());
            return false;
        }
    }

    public function listarProductos(): array {/*listar todos los productos*/
        try {
            /*$sql = "SELECT * FROM productos";*/
            $sql = "SELECT * FROM productos WHERE id NOT IN (SELECT producto_id FROM Ventas)";
            //queremos que solo nos muestre en el catálogo los que no aparecen en la tabla de ventas
            //es decir no han sido vendidos

            $stmt = $this->db->query($sql);

            $productos = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $productos[] = new Producto(
                    $row['id'],
                    $row['nombreProducto'],
                    $row['descripcionProducto'],
                    $row['precio'],
                    $row['categoriaProducto'],
                    $row['fechaRegistroProducto'],
                    $row['idVendedor']
                );
            }
            return $productos;
        } catch (PDOException $e) {
            error_log("Error al listar productos: " . $e->getMessage());
            return [];
        }
    }

    public function listarMisProductos(): array {/*listar todos mis productos*/
        try {
            /*$sql = "SELECT * FROM productos";*/
            $sql = "SELECT * FROM productos WHERE idVendedor = (SELECT userid FROM Usuarios)";
            //queremos que solo nos muestre en el catálogo los que no aparecen en la tabla de ventas
            //es decir no han sido vendidos

            $stmt = $this->db->query($sql);

            $productos = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $productos[] = new Producto(
                    $row['id'],
                    $row['nombreProducto'],
                    $row['descripcionProducto'],
                    $row['precio'],
                    $row['categoriaProducto'],
                    $row['fechaRegistroProducto'],
                    $row['idVendedor']
                );
            }
            return $productos;
        } catch (PDOException $e) {
            error_log("Error al listar mis productos: " . $e->getMessage());
            return [];
        }
    }

    public function eliminarProducto(string $id, string $idVendedor): bool {//eliminamos el producto con el id indicado solo si lo elimina el vendedor
        try {
            $sql = "DELETE FROM productos WHERE id = :id AND idVendedor = :idVendedor";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_STR);
            $stmt->bindValue(':idVendedor', $idVendedor, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al eliminar producto: " . $e->getMessage());
            return false;
        }
    }

    public function obtenerProductoPorId(string $id): ?Producto {/*buscar un producto en concreto por su id*/
        try {
            $sql = "SELECT * FROM productos WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_STR);
            $stmt->execute();
    
            // Si el producto se encuentra, crear y devolver el objeto Producto
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                // Suponiendo que tienes una clase Producto que se puede instanciar con estos datos
                return new Producto(
                    $row['id'],
                    $row['nombreProducto'],
                    $row['descripcionProducto'],
                    $row['precio'],
                    $row['categoriaProducto'],
                    $row['fechaRegistroProducto'],
                    $row['idVendedor']
                );
            }
            return null; // Si no se encuentra el producto, devolver null
        } catch (PDOException $e) {
            error_log("Error al obtener producto por id: " . $e->getMessage());
            return null;
        }
    }
    

    public function buscarProductosPorCategoria($categoria): array { /*listar productos por categoría*/
        $productosCat = [];
        $conexion = $this->db;

        if ($conexion) {
            $sql = "SELECT * FROM Productos WHERE categoriaProducto = :categoria";

            try {
                $consulta = $conexion->prepare($sql);
                $consulta->bindParam(':categoria', $categoria, PDO::PARAM_STR);
                $consulta->execute();
                $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);

                foreach ($resultados as $row) {
                    $productosCat[] = new Producto(
                        $row['id'],
                        $row['nombreProducto'],
                        $row['descripcionProducto'],
                        $row['precio'],
                        $row['categoriaProducto'],
                        $row['fechaRegistroProducto'],
                        $row['idVendedor']
                    );
                }
            } catch (PDOException $e) {
                error_log("Error al buscar productos por categoría: " . $e->getMessage());
            }
        }

        return $productosCat;
    }
}
?>
