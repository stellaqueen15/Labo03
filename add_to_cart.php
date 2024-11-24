<?php
session_start();
require_once 'ProductController.php';
require_once 'database.php';

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    header('Location: connexion.php');
    exit();
}

// Initialisez le panier si ce n'est pas encore fait
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$productId = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);

if ($productId) {
    $productController = new ProductController($database);
    $product = $productController->getProductById($productId);

    if ($product) {
        $_SESSION['cart'][] = [
            'id' => $product['id'],
            'name' => $product['name'],
            'prix' => $product['prix'],
            'image' => $product['image']
        ];
    }
}

// Redirigez vers la page du panier après l'ajout
header('Location: panier.php');
exit();
