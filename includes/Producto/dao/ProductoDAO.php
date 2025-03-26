<?php
require_once __DIR__ . '/../../database/Connection.php';
require_once __DIR__ . '/../model/Producto.php';
require_once __DIR__ . '/../../application.php';

class ProductoDAO { /*extiende de la base*/

    private $db;

    public function __construct() {
        $this->db = application::getInstance()->getConnection();
    }
    
    public function agregarProducto(Producto $producto) : bool { /*Agregar un nuevo producto*/
        try {
            $sql = "INSERT INTO productos (nombreProducto, descripcionProducto, precio, categoriaProducto, idVendedor, rutaImagen) 
                    VALUES (:nombre, :descripcion, :precio, :categoria, :idVendedor, :rutaImagen)";

            $stmt = $this->db->prepare($sql);

            // Asignar los valores a variables
            $nombre = $producto->getNombreProducto();
            $descripcion = $producto->getDescripcionProducto();
            $precio = $producto->getPrecio();
            $categoria = $producto->getCategoriaProducto();
            $idVendedor = $producto->getIdVendedor();
            $rutaImagen = $producto->getRutaImagen();

            // Pasar las variables a bindParam
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
            $stmt->bindParam(':precio', $precio, PDO::PARAM_INT);
            $stmt->bindParam(':categoria', $categoria, PDO::PARAM_STR);
            $stmt->bindParam(':idVendedor', $idVendedor, PDO::PARAM_STR);
            $stmt->bindParam(':rutaImagen', $rutaImagen, PDO::PARAM_STR);

            $result = $stmt->execute();
            if (!$result) {
                error_log("Error al ejecutar la consulta: " . implode(", ", $stmt->errorInfo()));
            }
            return $result;
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
                    $row['categoriaProducto'],
                    $row['idVendedor'],
                    $row['rutaImagen']
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
            $sql = "SELECT * FROM productos WHERE idVendedor = {$_SESSION['userid']}";
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
                    $row['idVendedor']
                );
            }
            return $productos;
        } catch (PDOException $e) {
            error_log("Error al listar mis productos: " . $e->getMessage());
            return [];
        }
    }

    public function eliminarProducto(string $nombreProducto, string $idVendedor) {//eliminamos el producto con el nombre indicado solo si lo elimina el vendedor
        try {
            $sql = "DELETE FROM productos WHERE nombreProducto = :nombreProducto AND idVendedor = :idVendedor";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':nombreProducto', $nombreProducto, PDO::PARAM_STR);
            $stmt->bindValue(':idVendedor', $idVendedor, PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return (object) ['message' => 'Producto eliminado correctamente'];
            } else {
                return (object) ['message' => 'No se ha encontrado el producto'];
            }
        } catch (PDOException $e) {
            error_log("Error al eliminar producto: " . $e->getMessage());
            return $e;
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

    public function obtenerUltimoIdProducto(): ?int {
        try {
            $sql = "SELECT id FROM productos ORDER BY id DESC LIMIT 1";
            $stmt = $this->db->query($sql);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row ? (int)$row['id'] : null;
        } catch (PDOException $e) {
            error_log("Error al obtener el último ID del producto: " . $e->getMessage());
            return null;
        }
    }
}
?>
