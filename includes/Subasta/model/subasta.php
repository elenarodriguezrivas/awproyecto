<?php
class Subasta {
    private $id;
    private $idProducto;
    private $fechaInicio;
    private $fechaFin;
    private $precioInicial;

    public function __construct($idProducto, $fechaInicio, $fechaFin, $precioInicial, $id = null) {
        $this->id = $id;
        $this->idProducto = $idProducto;
        $this->fechaInicio = $fechaInicio;
        $this->fechaFin = $fechaFin;
        $this->precioInicial = $precioInicial; //se me ha olvidado incluir el precio en la base de datos
    }

    // Getters
    public function getId() {
        return $this->id;
    }
    public function getIdProducto() {
        return $this->idProducto;
    }
    public function getFechaInicio() {
        return $this->fechaInicio;
    }
    public function getFechaFin() {
        return $this->fechaFin;
    }
    public function getPrecioInicial() {
        return $this->precioInicial;
    }
}
?>
