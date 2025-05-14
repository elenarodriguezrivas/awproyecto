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
        // subastas en curso ya vencidas
        $vencidas = $this->subastaDAO->obtenerVencidas();
        if (empty($vencidas)) { //si no hay, no hacemos nada
            return;
        }

        foreach ($vencidas as $s) { //por cada subasta vencida
            $idSubasta = (int) $s['id'];
            $vendedor  = $s['idVendedor'];

            //Obtener la puja más alta (si existe)
            $maxPuja = $this->pujaDAO->obtenerMaximaPorSubasta($idSubasta);

            //Marcar subasta como finalizada
            $this->subastaDAO->actualizarEstado($idSubasta, 'finalizada');

            //Registrar la venta si hubo puja ganadora
            if ($maxPuja !== null) {
                $compradorId = $maxPuja['idPujador'];
                $venta = new Venta($idSubasta, $compradorId, $vendedor);
                $this->ventaDAO->registrarVenta($venta);
            }
        }
    }
}
?>
