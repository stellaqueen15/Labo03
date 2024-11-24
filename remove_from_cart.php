<?php
session_start();

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    header('Location: connexion.php');
    exit();
}

// Vérifiez si le panier existe
if (!isset($_SESSION['cart'])) {
    header('Location: panier.php');
    exit();
}

// Récupérez l'index du produit à supprimer
$index = filter_input(INPUT_POST, 'index', FILTER_VALIDATE_INT);

if ($index !== null && $index >= 0 && $index < count($_SESSION['cart'])) {
    // Supprimez l'article du panier
    array_splice($_SESSION['cart'], $index, 1);
}

// Redirigez vers la page du panier
header('Location: panier.php');
exit();
