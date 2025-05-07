<?php

class Puja {
    private $idSubasta;
    private $idPujador;
    private $precio;

    public function __construct(int $idSubasta, string $idPujador, float $precio) {
        $this->idSubasta = $idSubasta;
        $this->idPujador = $idPujador;
        $this->precio = $precio;
    }

    public function getIdSubasta(){ 
        return $this->idSubasta; 
    }

    public function getIdPujador(){ 
        return $this->idPujador; 
    }

    public function getPrecio(){ 
        return $this->precio; 
    }
}
