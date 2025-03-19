<?php
// VentaDAO.php
require_once __DIR__ . '/../../database/Connection.php';
require_once __DIR__ . '/../model/Venta.php';

class VentaDAO extends DB {
    public function registrarVenta(Venta $venta): bool {
        try {
            $sql = "INSERT INTO Ventas (producto_id, user_id, fechaVenta, comprador_id, precio) 
                    VALUES (:producto_id, :user_id, :fechaVenta, :comprador_id, :precio)";

            $stmt = $this->db->prepare($sql);

            // Asignar los valores a las variables
            $producto_id = $venta->getProductoId();
            $user_id = $venta->getUserId();
            $fechaVenta = $venta->getFechaVenta();
            $comprador_id = $venta->getCompradorId();
            $precio = $venta->getPrecio();

            // Pasar las variables a bindParam
            $stmt->bindParam(':producto_id', $producto_id, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
            $stmt->bindParam(':fechaVenta', $fechaVenta, PDO::PARAM_INT);
            $stmt->bindParam(':comprador_id', $comprador_id, PDO::PARAM_STR);
            $stmt->bindParam(':precio', $precio, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al registrar la venta: " . $e->getMessage());
            return false;
        }
    }
}
?>