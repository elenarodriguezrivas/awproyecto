<?php
require_once __DIR__.'/../../Subasta/dao/SubastaDAO.php';
require_once __DIR__.'/../../Puja/dao/PujaDAO.php';
require_once __DIR__.'/../../Ventas/dao/VentaDAO.php';

class finalizarSubastaSA {
    private $subastaDAO;
    private $pujaDAO;
    private $ventaDAO;

    public function __construct() {
        $this->subastaDAO = new SubastaDAO(); //para cambiar el estado de la subasta a finalizada
        $this->pujaDAO    = new PujaDAO(); //para coger el id del usuario de la puja ganadora
        $this->ventaDAO   = new VentaDAO(); //registrar la venta
    }

    public function cerrarVencidas(): void { // Cierra las subastas vencidas
        $vencidas = $this->subastaDAO->obtenerVencidas(); //cojo las subastas vencidas
        if (empty($vencidas)) {
            return; // No hay subastas vencidas
        }
        
        foreach ($vencidas as $s) {
            try {
                $idSubasta = (int)$s['id'];
                $vend  = $s['idVendedor'];

                // 1) Obtener la puja más alta. Esto todavía no esta bien, porque obtener maxima puja devuelve otra cosa
                $maxPuja = $this->pujaDAO->obtenerMaximaPorSubasta($idSubasta);

                // 2) Marcar subasta como finalizada
                if (!$this->subastaDAO->actualizarEstado($idSubasta, 'finalizada')) {
                    throw new Exception("Error actualizando estado de subasta $idSubasta");
                }

                // 3) Registrar venta si existe puja ganadora
                if ($maxPuja !== null) {
                    $comp = $maxPuja['idPujador'];
                    $venta = new Venta($idSubasta, $comp, $vend); // Crear objeto Venta
                    if (!$this->ventaDAO->registrarVenta($venta)) {
                        throw new Exception("Error insertando venta de subasta $idSubasta");
                    }
                }
            } catch (Exception $e) {
                error_log($e->getMessage());
            }
        }
    }
}
?>
