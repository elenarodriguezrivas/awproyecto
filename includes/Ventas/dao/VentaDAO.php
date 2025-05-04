<?php
// VentaDAO.php
require_once __DIR__ . '/../../database/Connection.php';
require_once __DIR__ . '/../model/Venta.php';

class VentaDAO{

    private $db;

    public function __construct() {
        $this->db = DB::getInstance()->getBD();
    }

    public function registrarVenta(Venta $venta) {
        try {
            $sql = "INSERT INTO Ventas (producto_id, vendedor_id, comprador_id) 
                    VALUES (:producto_id, :vendedor_id, :comprador_id)";

            $stmt = $this->db->prepare($sql);

            // Asignar los valores a las variables
            $producto_id = $venta->getProductoId();
            $vendedor_id = $venta->getVendedorId();
            $comprador_id = $venta->getCompradorId();

            // Pasar las variables a bindParam
            $stmt->bindParam(':producto_id', $producto_id, PDO::PARAM_INT);
            $stmt->bindParam(':vendedor_id', $vendedor_id, PDO::PARAM_STR);
            $stmt->bindParam(':comprador_id', $comprador_id, PDO::PARAM_STR);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                return true; // Venta registrada con éxito
            } else {
                error_log("Error al registrar la venta: No se pudo ejecutar la consulta.");
                return false;
            }
        } catch (PDOException $e) {
            error_log("Error al registrar la venta: " . $e->getMessage());
            return $e;
        }
    }

    public function obtenerComprasPorUsuario($userid) {
    try {
        $sql = "SELECT v.producto_id, p.nombreProducto, p.precio, p.categoriaProducto, p.rutaImagen 
                FROM Ventas v
                JOIN Productos p ON v.producto_id = p.id
                WHERE v.comprador_id = :userid";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':userid', $userid, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error al obtener compras del usuario: " . $e->getMessage());
        return [];
    }
    }
}
?>