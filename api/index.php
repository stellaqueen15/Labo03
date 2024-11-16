<?php
require_once '../UserController.php';
require_once '../ProductController.php';
require_once '../ProductView.php';
require_once '../database.php';
require_once '../nettoyage.php';
session_start();

// Récupère l'URI et la méthode HTTP
$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

// Instancie le contrôleur
$productController = new ProductController($database);
$userController = new UserController($database);

//GET pour avoir les produits
if ($method == 'GET' && $uri == '/Labo03/api/produits') {
    header('Content-Type: application/json');
    $produits = $productController->getAllProducts();
    echo json_encode($produits);
    exit;
}
//GET pour avoir un produit selon son id
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
//GET pour avoir les tailles des produits
if ($method == 'GET' && preg_match('/^\/Labo03\/api\/taille\/(\d+)$/', $uri, $matches)) {
    $productId = $matches[1];
    header('Content-Type: application/json');

    // Appeler la méthode pour récupérer uniquement les tailles
    $tailles = $productController->getSizesByProductId($productId);

    if ($tailles) {
        echo json_encode($tailles);
    } else {
        echo json_encode(["success" => false, "message" => "Aucune taille trouvée pour ce produit"]);
    }
    exit;
}
//GET pour avoir les produits aléatoires
if ($method == 'GET' && $uri == '/Labo03/api/produitsAle') {
    header('Content-Type: application/json');

    $productId = isset($_GET['id']) ? intval($_GET['id']) : null;

    $produitsAle = $productController->getRandomProducts(3, $productId);

    echo json_encode($produitsAle);
    exit;
}
//PUT pour modifier un utilisateur
if ($method == 'PUT' && preg_match('/^\/Labo03\/api\/user\/(\d+)$/', $uri, $matches)) {
    $userId = $matches[1];

    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data) {
        echo json_encode(['success' => false, 'message' => 'Données invalides ou absentes.']);
        exit();
    }

    $nouveauNom = !empty($data['nom']) ? trim(sanitizeString($data['nom'])) : $_SESSION['name'];
    $nouvelEmail = !empty($data['email']) ? trim(sanitizeString($data['email'])) : $_SESSION['email'];
    $nouveauMotDePasse = !empty($data['password']) ? trim(sanitizeString($data['password'])) : null;

    if (strlen($nouveauNom) < 3) {
        echo json_encode(['success' => false, 'message' => "Le nom doit comporter au moins 3 caractères."]);
        exit();
    }
    if (!empty($nouveauMotDePasse) && strlen($nouveauMotDePasse) < 8) {
        echo json_encode(['success' => false, 'message' => "Le mot de passe doit comporter au moins 8 caractères."]);
        exit();
    }
    if (!empty($nouveauMotDePasse) && strpos($nouveauMotDePasse, ' ') !== false) {
        echo json_encode(['success' => false, 'message' => "Le mot de passe ne doit pas contenir d'espaces."]);
        exit();
    }
    if (!filter_var($nouvelEmail, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => "L'adresse e-mail n'est pas valide."]);
        exit();
    }

    $nouveauMotDePasseHash = $_SESSION['password'];
    if (!empty($nouveauMotDePasse)) {
        $nouveauMotDePasseHash = password_hash($nouveauMotDePasse, PASSWORD_DEFAULT);
    }

    $userController->updateUser($userId, $nouveauNom, $nouvelEmail, $nouveauMotDePasseHash);

    $_SESSION['name'] = $nouveauNom;
    $_SESSION['email'] = $nouvelEmail;

    // Réponse de succès
    echo json_encode(['success' => true, 'message' => "Mise à jour réussie."]);
    exit();
}
// DELETE
if ($method == 'DELETE' && preg_match('/^\/Labo03\/api\/user\/(\d+)$/', $uri, $matches)) {
    $userId = $matches[1];
    if ($userController->deleteUser($userId)) {
        echo json_encode(['success' => true, 'message' => 'Utilisateur supprimé']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erreur de suppression']);
    }
    exit();
}
// POST pour ajouter un utilisateur
if ($method == 'POST' && $uri == '/Labo03/api/user') {
    $data = json_decode(file_get_contents('php://input'), true);
    $name = sanitizeString($data['name']);
    $email = sanitizeString($data['email']);
    $password = password_hash(sanitizeString($data['password']), PASSWORD_DEFAULT);
    if ($userController->createUser($name, $email, $password)) {
        echo json_encode(['success' => true, 'message' => 'Utilisateur ajouté']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erreur d\'ajout']);
    }
    exit();
} else {
    header('HTTP/1.1 404 Not Found');
    echo json_encode(["error" => "Route non trouvée"]);
    exit;
}