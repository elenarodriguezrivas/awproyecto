<?php
require_once __DIR__ . '/../../database/Connection.php';
require_once __DIR__ . '/../model/Anuncio.php';

class ProductoDAO extends DB {
    
    public function agregarProducto(Producto $producto): bool {
        try {
            $sql = "INSERT INTO productos (nombreProducto, descripcionProducto, precio, vendedor, comprador) 
                    VALUES (:nombre, :descripcion, :precio, :vendedor, :comprador)";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':nombre', $producto->getNombreProducto(), PDO::PARAM_STR);
            $stmt->bindParam(':descripcion', $producto->getDescripcionProducto(), PDO::PARAM_STR);
            $stmt->bindParam(':precio', $producto->getPrecio(), PDO::PARAM_STR);
            $stmt->bindParam(':vendedor', $producto->getVendedor(), PDO::PARAM_STR);
            $stmt->bindParam(':comprador', $producto->getComprador(), PDO::PARAM_STR);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al agregar producto: " . $e->getMessage());
            return false;
        }
    }

    public function listarProductos(): array {
        try {
            $sql = "SELECT * FROM productos";
            $stmt = $this->db->query($sql);

            $productos = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $productos[] = new Producto(
                    $row['nombreProducto'],
                    $row['descripcionProducto'],
                    $row['precio'],
                    $row['vendedor'],
                    $row['comprador']
                );
            }
            return $productos;
        } catch (PDOException $e) {
            error_log("Error al listar productos: " . $e->getMessage());
            return [];
        }
    }

    public function eliminarProducto(int $id): bool {
        try {
            $sql = "DELETE FROM productos WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al eliminar producto: " . $e->getMessage());
            return false;
        }
    }
}
?>
