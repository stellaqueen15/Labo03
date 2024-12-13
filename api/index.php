<?php
require_once '../UserController.php';
require_once '../ProductController.php';
require_once '../UserView.php';
require_once '../ProductView.php';
require_once '../database.php';
require_once '../nettoyage.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

$productController = new ProductController($database);
$userController = new UserController($database);

// Vérifier si l'utilisateur est connecté
if ($method == 'GET' && $uri == '/Labo03/api/check-login') {

    if (isset($_SESSION['email'])) {
        echo json_encode(['loggedIn' => true]);
    } else {
        echo json_encode(['loggedIn' => false]);
    }
    exit();
}

// GET pour avoir les tailles des produits
if ($method == 'GET' && preg_match('/^\/Labo03\/api\/taille\/(\d+)$/', $uri, $matches)) {
    $productId = $matches[1];
    header('Content-Type: application/json');

    $query = $database->prepare("
        SELECT taille 
        FROM quantites_par_taille 
        WHERE produit_id = ? AND quantite > 0
        ORDER BY taille
    ");
    $query->execute([$productId]);

    $tailles = $query->fetchAll(PDO::FETCH_COLUMN);

    if ($tailles) {
        echo json_encode($tailles);
    } else {
        echo json_encode([]);
    }
    exit();
}

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

// GET /api/commande/status
if ($method == 'GET' && $uri == '/Labo03/api/commande/status') {
    if (isset($_GET['success']) && $_GET['success'] == 1) {
        echo json_encode([
            'success' => true,
            'message' => 'Merci pour votre commande ! Votre commande est en cours de traitement.'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Une erreur est survenue. Veuillez réessayer.'
        ]);
    }
    exit();
}

// GET pour afficher le profil d'un utilisateur
if ($method === 'GET' && $uri === '/Labo03/api/user/profil') {
    if (!isset($_SESSION['email'])) {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Session expirée. Veuillez vous reconnecter.']);
        exit();
    }

    try {
        $email = $_SESSION['email'];
        $query = $database->prepare('SELECT id, name, email FROM users WHERE email = ?');
        $query->execute([$email]);
        $user = $query->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Utilisateur introuvable.']);
            exit();
        }

        echo json_encode(['success' => true, 'user' => $user]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Erreur lors de la récupération du profil.']);
    }
    exit();
}

// GET pour avoir le statut de si l'utilisateur est abonné à l'infolettre ou non
if ($method == 'GET' && $uri == '/Labo03/api/infolettre/status') {
    header('Content-Type: application/json');

    if (!isset($_SESSION['email'])) {
        http_response_code(401);
        echo json_encode([
            'success' => false,
            'message' => 'Utilisateur non connecté.',
        ]);
        exit();
    }

    $email = $_SESSION['email'];

    $recupInfolettre = $database->prepare('SELECT * FROM abonnements_infolettre WHERE email = ?');
    $recupInfolettre->execute([$email]);

    $abonnementStatus = $recupInfolettre->rowCount() > 0
        ? "Abonné(e) à l'infolettre"
        : "Non abonné(e) à l'infolettre";

    echo json_encode([
        'success' => true,
        'status' => $abonnementStatus,
    ]);
    exit();
}

//PUT pour modifier un utilisateur
if ($method === 'PUT' && $uri === '/Labo03/api/user') {
    if (!isset($_SESSION['email'])) {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Non autorisé.']);
        exit();
    }

    try {
        $data = json_decode(file_get_contents('php://input'), true);
        $name = sanitizeString($data['name']);
        $email = sanitizeString($data['email']);
        $currentPassword = $data['currentPassword'];
        $newPassword = $data['newPassword'] ?? null;
        $currentEmail = $_SESSION['email'];

        $query = $database->prepare('SELECT password FROM users WHERE email = ?');
        $query->execute([$currentEmail]);
        $user = $query->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($currentPassword, $user['password'])) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Mot de passe actuel incorrect.']);
            exit();
        }

        $updateQuery = $database->prepare('UPDATE users SET name = ?, email = ? WHERE email = ?');
        $updateQuery->execute([$name, $email, $currentEmail]);

        if ($newPassword) {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $updatePasswordQuery = $database->prepare('UPDATE users SET password = ? WHERE email = ?');
            $updatePasswordQuery->execute([$hashedPassword, $email]);
        }

        $_SESSION['email'] = $email; // Met à jour l'email dans la session
        echo json_encode(['success' => true, 'message' => 'Profil mis à jour avec succès.']);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Erreur lors de la mise à jour du profil.', 'error' => $e->getMessage()]);
    }
    exit();
}

// DELETE pour supprimer un utilisateur
if ($method === 'DELETE' && $uri === '/Labo03/api/user') {
    if (!isset($_SESSION['email'])) {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Non autorisé.']);
        exit();
    }

    try {
        $email = $_SESSION['email'];

        $deleteQuery = $database->prepare('DELETE FROM users WHERE email = ?');
        $deleteQuery->execute([$email]);

        session_unset();
        session_destroy();

        echo json_encode(['success' => true, 'message' => 'Compte supprimé avec succès.']);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Erreur lors de la suppression du compte.', 'error' => $e->getMessage()]);
    }
    exit();
}

// POST pour se déconnecter
if ($method === 'POST' && $uri === '/Labo03/api/deconnexion') {

    if (!isset($_SESSION['email'])) {
        http_response_code(401);
        echo json_encode([
            'success' => false,
            'message' => 'Utilisateur non connecté.',
        ]);
        exit();
    }

    session_unset();
    session_destroy();

    echo json_encode([
        'success' => true,
        'message' => 'Déconnexion réussie.'
    ]);
    exit();
}

if ($method == 'POST' && $uri == '/Labo03/api/user') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data) {
        echo json_encode(['success' => false, 'message' => 'Aucune donnée reçue ou format incorrect']);
        exit();
    }

    $name = sanitizeString($data['name']);
    $email = sanitizeString($data['email']);
    $password = password_hash(sanitizeString($data['password']), PASSWORD_DEFAULT);

    if ($userController->createUser($name, $email, $password)) {
        echo json_encode(['success' => true, 'message' => 'Utilisateur ajouté']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erreur d\'ajout']);
    }
    exit();
}

// POST pour la connexion de l'utilisateur
if ($method == 'POST' && $uri == '/Labo03/api/login') {
    $data = json_decode(file_get_contents('php://input'));

    $email = isset($data->email) ? trim(sanitizeString($data->email)) : '';
    $password_user = isset($data->password) ? trim(sanitizeString($data->password)) : '';

    if (empty($email) || empty($password_user)) {
        echo json_encode(['message' => 'Email et mot de passe sont requis.']);
        http_response_code(400);
        exit();
    }

    $recupUser = $database->prepare('SELECT * FROM users WHERE email = ?');
    $recupUser->execute(array($email));

    if ($recupUser->rowCount() > 0) {
        $user = $recupUser->fetch();
        if (password_verify($password_user, $user['password'])) {
            $_SESSION['email'] = $email;
            $_SESSION['name'] = $user['name'];
            $_SESSION['id'] = $user['id'];

            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => 'Connexion réussie.',
                'user' => [
                    'id' => $user['id'],
                    'email' => $user['email'],
                    'name' => $user['name']
                ],
            ]);
        } else {
            echo json_encode(['message' => 'Mot de passe incorrect.']);
            http_response_code(401);
        }
    } else {
        echo json_encode(['message' => 'Aucun utilisateur trouvé avec cet email.']);
        http_response_code(404);
    }
    exit();
}

// POST pour s'inscrire à l'infolettre
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $uri === '/Labo03/api/subscribe-newsletter') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['email-newsletter'])) {
        $email = filter_var($data['email-newsletter'], FILTER_SANITIZE_EMAIL);

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $query = $database->prepare('SELECT * FROM abonnements_infolettre WHERE email = ?');
            $query->execute([$email]);
            $existingUser = $query->fetch();

            if (!$existingUser) {
                $stmt = $database->prepare('INSERT INTO abonnements_infolettre (email) VALUES (?)');
                if ($stmt->execute([$email])) {
                    echo json_encode(["success" => true, "message" => "Merci de vous être abonné à notre infolettre !"]);
                } else {
                    echo json_encode(["success" => false, "message" => "Une erreur est survenue lors de l'inscription. Veuillez réessayer."]);
                }
            } else {
                echo json_encode(["success" => false, "message" => "Cet e-mail est déjà inscrit à notre infolettre."]);
            }
        } else {
            echo json_encode(["success" => false, "message" => "Veuillez entrer une adresse e-mail valide."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "L'email est requis."]);
    }
    exit();
} else {
    header('HTTP/1.1 404 Not Found');
    echo json_encode(["error" => "Route non trouvée"]);
    exit;
}