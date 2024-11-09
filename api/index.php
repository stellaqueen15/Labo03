<?php
require_once '../ProductController.php';
require_once '../ProductView.php';
require_once '../database.php';

// Récupère l'URI et la méthode HTTP
$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

// Instancie le contrôleur
$productController = new ProductController($database);

if ($method == 'GET' && $uri == '/Labo03/api/produits') {
    header('Content-Type: application/json');
    $produits = $productController->getAllProducts();
    echo json_encode($produits);
    exit;
}
if ($method == 'GET' && preg_match('/^\/Labo03\/api\/produit\/(\d+)$/', $uri, $matches)) {
    $id = $matches[1];

    header('Content-Type: application/json');

    $produit = $productController->getProductById($id);

    if ($produit) {
        echo json_encode($produit);
    } else {
        echo json_encode(["success" => false, "message" => "Produit non trouvé"]);
    }
    exit;
}
if ($method == 'GET' && $uri == '/Labo03/api/produitsAle') {
    header('Content-Type: application/json');

    $productId = isset($_GET['id']) ? intval($_GET['id']) : null;

    $produitsAle = $productController->getRandomProducts(3, $productId);

    echo json_encode($produitsAle);
    exit;
}
if ($method == 'GET' && preg_match('/^\/Labo03\/api\/user\/(\d+)$/', $uri, $matches)) {
    echo "Mise à jour des détails d'un utilisateur spécifique.";
    exit;
} else {
    header('HTTP/1.1 404 Not Found');
    echo json_encode(["error" => "Route non trouvée"]);
    exit;
}