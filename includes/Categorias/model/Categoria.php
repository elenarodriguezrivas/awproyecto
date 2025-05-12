<?php

class Categoria {
    private $nombreCategoria;

    public function __construct($categoria) {
        $this->nombreCategoria = $categoria;
       
    }

    public function getCategoria(){
        return $this->nombreCategoria;
    }

}
?>