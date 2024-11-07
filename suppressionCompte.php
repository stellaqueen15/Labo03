<?php
session_start();
require_once 'UserController.php';
require_once 'database.php';

if (!isset($_SESSION['id'])) {
    header('Location: connexion.php');
    exit;
}

$userController = new UserController($database);

$userId = $_SESSION['id'];

if ($userController->deleteUser($userId)) {
    session_destroy();
    header('Location: index.php');
    exit;
} else {
    echo "Erreur lors de la suppression du compte.";
}
