<?php
require_once __DIR__ . '/../dao/CategoriaDAO.php';
require_once __DIR__ . '/../model/Categoria.php';

class agregarCategoriaSA {
    private $categoriasDAO;

    public function __construct() {
        $this->categoriasDAO = new CategoriaDAO();
    }

    public function agregarCategoria(Categoria $categoria): bool{
        return $this->categoriasDAO->agregarCategoria($categoria);
    }

}

?>