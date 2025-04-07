<?php
class Puja {
    private $id;
    private $idSubasta;
    private $idUsuario;
    private $cantidad;
    private $fecha;

    public function __construct($idSubasta, $idUsuario, $cantidad, $fecha, $id = null) {
        $this->id = $id;
        $this->idSubasta = $idSubasta;
        $this->idUsuario = $idUsuario;
        $this->cantidad = $cantidad;
        $this->fecha = $fecha;
    }

    // Getters
    public function getId() {
        return $this->id;
    }
    public function getIdSubasta() {
        return $this->idSubasta;
    }
    public function getIdUsuario() {
        return $this->idUsuario;
    }
    public function getCantidad() {
        return $this->cantidad;
    }
    public function getFecha() {
        return $this->fecha;
    }
}
?>
