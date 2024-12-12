<?php
// Ajouter les en-têtes CORS
header("Access-Control-Allow-Origin: *"); // Permet à toutes les origines d'accéder à la ressource
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); // Méthodes HTTP autorisées
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // En-têtes autorisés

// Pour les requêtes OPTIONS (prévol), répondre immédiatement sans traitement
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once 'stripe-php-master/init.php';

// Remplace 'YOUR_SECRET_KEY' par ta clé secrète Stripe
\Stripe\Stripe::setApiKey('sk_test_51QUwMsHysDGSSOG5OAI2GZ4UMMOfXrnbKE9PHLILqhFpxAneuQYbIWSsuNai7orWSL06Ik8EZk7kdXfWQHYTkEes008AydCqvd');

// Récupère les données envoyées par le frontend
$data = json_decode(file_get_contents('php://input'), true);

// Vérifier si 'totalAmount' existe et est un nombre
if (!isset($data['totalAmount']) || !is_numeric($data['totalAmount'])) {
    echo json_encode(['error' => 'Le montant total est manquant ou invalide.']);
    exit();
}

$totalAmount = $data['totalAmount']; // Montant total en centimes

// Créer une session de paiement
$checkout_session = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card'],
    'line_items' => [
        [
            'price_data' => [
                'currency' => 'usd',  // Remplace par la devise de ton choix
                'product_data' => [
                    'name' => 'Produit Exemple',
                ],
                'unit_amount' => $totalAmount,  // Utilise le montant total reçu du frontend
            ],
            'quantity' => 1,
        ],
    ],
    'mode' => 'payment',
    'success_url' => 'http://localhost:3000/success', // Page de succès
    'cancel_url' => 'http://localhost:3000/cancel',   // Page d'annulation
]);

// Renvoyer l'ID de la session Stripe au frontend
echo json_encode(['id' => $checkout_session->id]);

