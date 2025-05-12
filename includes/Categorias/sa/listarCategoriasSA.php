<?php
require_once __DIR__ . '/../dao/CategoriaDAO.php';
require_once __DIR__ . '/../model/Categoria.php';

class listarCategoriasSA {
    private $categoriasDAO;

    public function __construct() {
        $this->categoriasDAO = new CategoriaDAO();
    }

    public function listarCategorias(): array {
        return $this->categoriasDAO->listarCategorias();
    }
    
}

?>