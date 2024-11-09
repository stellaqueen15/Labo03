<?php
require_once '../ProductController.php';
require_once '../ProductView.php';
require_once '../database.php';
session_start();

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
if ($_SERVER['REQUEST_METHOD'] == 'PUT' && preg_match('/^\/Labo03\/api\/user\/(\d+)$/', $uri, $matches)) {
    $userId = $matches[1];

    if (!isset($_SESSION['id']) || $_SESSION['id'] != $userId) {
        echo json_encode(['success' => false, 'message' => 'Accès non autorisé']);
        exit();
    }

    $data = json_decode(file_get_contents('php://input'), true);

    $nouveauNom = !empty($data['nom']) ? trim(sanitizeString($data['nom'])) : $_SESSION['name'];
    $nouvelEmail = !empty($data['email']) ? trim(sanitizeString($data['email'])) : $_SESSION['email'];
    $nouveauMotDePasse = !empty($data['password']) ? trim(sanitizeString($data['password'])) : $_SESSION['password'];

    if (strlen($nouveauNom) < 3) {
        echo json_encode(['success' => false, 'message' => 'Le nom doit comporter au moins 3 caractères.']);
        exit();
    } elseif (strlen($nouveauMotDePasse) < 8 && !empty($nouveauMotDePasse)) {
        echo json_encode(['success' => false, 'message' => 'Le mot de passe doit comporter au moins 8 caractères.']);
        exit();
    } elseif (strpos($nouveauMotDePasse, ' ') !== false) {
        echo json_encode(['success' => false, 'message' => 'Le mot de passe ne doit pas contenir d\'espaces.']);
        exit();
    } elseif (!filter_var($nouvelEmail, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'L\'adresse e-mail n\'est pas valide.']);
        exit();
    }

    $nouveauMotDePasseHash = $_SESSION['password'];
    if (!empty($nouveauMotDePasse)) {
        $nouveauMotDePasseHash = password_hash($nouveauMotDePasse, PASSWORD_DEFAULT);
    }

    $userController->updateUser($userId, $nouveauNom, $nouvelEmail, $nouveauMotDePasseHash);

    echo json_encode(['success' => true, 'message' => 'Mise à jour réussie']);
    exit();
} else {
    header('HTTP/1.1 404 Not Found');
    echo json_encode(["error" => "Route non trouvée"]);
    exit;
}