<?php
require_once 'ProductModel.php';
class ProductController
{
    private $model;

    public function __construct($database)
    {
        $this->model = new ProductModel($database);
    }

    public function getAllProducts()
    {
        return $this->model->getAllProducts();
    }

    public function getProductById($id)
    {
        return $this->model->getProductById($id);
    }

    public function getRandomProducts($limit, $currentProductId)
    {
        return $this->model->getRandomProducts($limit, $currentProductId);
    }

    public function filterProducts($type = null, $couleur = null, $taille = null, $prix_min = null, $prix_max = null)
    {
        return $this->model->getFilteredProducts($type, $couleur, $taille, $prix_min, $prix_max);
    }
}
?>