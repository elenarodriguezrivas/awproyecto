<?php
require_once __DIR__.'/../../Connection.php'; 

require_once __DIR__.'/../../Subasta/dao/SubastaDAO.php';
require_once __DIR__.'/../../Puja/dao/PujaDAO.php';
require_once __DIR__.'/../../Ventas/dao/VentaDAO.php';

class CloseSubastasSA {
    private PDO $db;
    private SubastaDAO $subastaDAO;
    private PujaDAO    $pujaDAO;
    private VentaDAO   $ventaDAO;

    public function __construct() {
        $this->db         = Connection::getInstance();
        $this->subastaDAO = new SubastaDAO($this->db);
        $this->pujaDAO    = new PujaDAO($this->db);
        $this->ventaDAO   = new VentaDAO($this->db);
    }

    /**
     * Cierra todas las subastas vencidas:
     * - Cambia a estado 'finalizada'.
     * - Si hubo puja, registra venta.
     */
    public function cerrarVencidas(): void {
        $vencidas = $this->subastaDAO->obtenerVencidas();

        foreach ($vencidas as $s) {
            $this->db->beginTransaction();
            try {
                $idSub = (int)$s['id'];
                $vend  = $s['idVendedor'];

                // 1) Obtener la puja más alta
                $max = $this->pujaDAO->obtenerMaximaPorSubasta($idSub);

                // 2) Marcar subasta como finalizada
                if (!$this->subastaDAO->actualizarEstado($idSub, 'finalizada')) {
                    throw new Exception("Error actualizando estado de subasta $idSub");
                }

                // 3) Registrar venta si existe puja ganadora
                if ($max !== null) {
                    $comp = $max['idPujador'];
                    if (!$this->ventaDAO->insertar($idSub, $vend, $comp)) {
                        throw new Exception("Error insertando venta de subasta $idSub");
                    }
                }

                $this->db->commit();
            } catch (Exception $e) {
                $this->db->rollBack();
                error_log($e->getMessage());
            }
        }
    }
}
?>
