<?php
require_once 'vendor/autoload.php'; // Charge le SDK Stripe

\Stripe\Stripe::setApiKey('YOUR_SECRET_KEY'); // Remplace par ta clé secrète

// Récupère les données envoyées par le frontend
$data = json_decode(file_get_contents('php://input'), true);
$totalAmount = $data['totalAmount']; // Montant total en centimes

$YOUR_DOMAIN = 'http://localhost:4242'; // Remplace par ton domaine

// Créer une session de paiement avec Stripe
$checkout_session = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card'],
    'line_items' => [
        [
            'price_data' => [
                'currency' => 'eur',
                'product_data' => [
                    'name' => 'Panier de produits',
                ],
                'unit_amount' => $totalAmount,
            ],
            'quantity' => 1,
        ],
    ],
    'mode' => 'payment',
    'success_url' => 'http://localhost:8080/success',  // URL Vue.js pour succès
    'cancel_url' => 'http://localhost:8080/cancel',    // URL Vue.js pour annulation
]);

// Retourne l'ID de la session au frontend
echo json_encode(['id' => $checkout_session->id]);
