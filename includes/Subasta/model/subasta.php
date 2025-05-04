<?php
class Subasta {
    private $id;
    private $idProducto;
    private $fechaSubasta;
    private $estado;
    private $precio;

    public function __construct($id, $idProducto, $fechaSubasta, $estado, $precio) {
        $this->id = $id;
        $this->idProducto = $idProducto;
        $this->fechaSubasta = $fechaSubasta;
        $this->estado = $estado;
        $this->precio = $precio; 
    }

    // Getters
    public function getId() {
        return $this->id;
    }
    public function getIdProducto() {
        return $this->idProducto;
    }
    public function getfechaSubasta() {
        return $this->fechaSubasta;
    }
    public function getEstado() {
        return $this->estado;
    }
    public function getPrecio() {
        return $this->precio;
    }
}
?>
