<?php

class Subasta {
    private $id;
    private $nombreSubasta;
    private $descripcionSubasta;
    private $precio_original;
    private $precio_actual;
    private $idVendedor;
    private $rutaImagen;
    private $estado;
    private $fechaSubasta;
    private $horaSubasta;

    public function __construct($id,$nombreSubasta, $descripcionSubasta, $precio_original, $precio_actual, $idVendedor, $rutaImagen, $estado, $fechaSubasta, $horaSubasta) {
        $this->id = $id;
        $this->nombreSubasta = $nombreSubasta;
        $this->descripcionSubasta = $descripcionSubasta;
        $this->precio_original = $precio_original;
        $this->precio_actual = $precio_actual;
        $this->idVendedor = $idVendedor;
        $this->rutaImagen = $rutaImagen;
        $this->estado = $estado;
        $this->fechaSubasta = $fechaSubasta;
        $this->horaSubasta = $horaSubasta;
    }

    public function getId(){
        return $this->id;
    }

    public function getNombreSubasta() {
        return $this->nombreSubasta;
    }

    public function getDescripcionSubasta() {
        return $this->descripcionSubasta;
    }

    public function getPrecio_original() {
        return $this->precio_original;
    }

    public function getPrecio_actual() {
        return $this->precio_actual;
    }

    public function getIdVendedor() {
        return $this->idVendedor;
    }

    public function getRutaImagen() {
        return $this->rutaImagen;
    }

    public function getEstado(){
        return $this->estado;
    }

    public function getFechaSubasta() {
        return $this->fechaSubasta;
    }

    public function getHoraSubasta() {
        return $this->horaSubasta;
    }
}
?>