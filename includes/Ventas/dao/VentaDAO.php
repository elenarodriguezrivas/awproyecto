<?php
// VentaDAO.php
require_once __DIR__ . '/../../database/Connection.php';
require_once __DIR__ . '/../model/Venta.php';

class VentaDAO{

    private $db;

    public function __construct() {
        $this->db = DB::getInstance()->getBD();
    }

    public function registrarVenta(Venta $venta): bool {
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
            $stmt->bindParam(':comprador_id', $comprador_id, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al registrar la venta: " . $e->getMessage());
            return false;
        }
    }
}
?>