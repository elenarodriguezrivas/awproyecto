<?php

class Cesta{
    private string $userId;
    private $productosCesta;

    public function __construct($userId, $productosCesta){
        $this->userId = $userId;
        $this->productosCesta = $productosCesta;
    }

    public function getUserId(){
        return $this->userId;
    }

    public function getProductosCesta(){
        return $this->productosCesta;
    }

}

?>