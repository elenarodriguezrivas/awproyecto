<?php
require_once __DIR__ . '/../dao/CategoriaDAO.php';
require_once __DIR__ . '/../model/Categoria.php';

class eliminarCategoriaSA {
    private $categoriasDAO;

    public function __construct() {
        $this->categoriasDAO = new CategoriaDAO();
    }
    
    public function eliminarCategoria($categoria) {
        return $this->categoriasDAO->eliminarCategoria($categoria);
    }
}

?>