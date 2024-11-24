<?php
include 'ProductController.php';
require_once 'database.php';
session_start();

$productId = $_GET['id'] ?? null;
$productController = new ProductController($database);
$product = $productController->getProductById($productId);
$randomProducts = $productController->getRandomProducts(3, $productId);

if (!$product) {
    echo "Produit introuvable.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@100..800&display=swap" rel="stylesheet" />
    <title>Rich Ricasso - Produit</title>
</head>

<body class="sora-font">
    <?php include('header.php'); ?>
    <div class="fenetre">
        <div class="barre">
            <span class="titre-fenetre">Fenêtre Produit</span>
            <div class="boutons-fenetre">
                <span class="moins">-</span>
                <span class="ouvrir">[ ]</span>
                <span class="fermer">X</span>
            </div>
        </div>
        <main class="page-produits-details">
            <h1><?= htmlspecialchars($product['name']) ?></h1>
            <div class="product-container-details">
                <div class="product-imagess">
                    <img id="main-image" src="<?= htmlspecialchars($product['image']) ?>"
                        alt="<?= htmlspecialchars($product['name']) ?>" class="main-product-image" />
                </div>
                <div class="product-details">
                    <p><strong>Type:</strong> <?= htmlspecialchars($product['type']) ?></p>
                    <p><strong>Couleur:</strong> <?= htmlspecialchars($product['couleur']) ?></p>
                    <p><strong>Prix:</strong> <?= htmlspecialchars($product['prix']) ?> €</p>
                    <p><strong>Description:</strong> <?= htmlspecialchars($product['description']) ?></p>

                    <!-- Formulaire pour ajouter au panier -->
                    <form action="add_to_cart.php" method="POST">
                        <input type="hidden" name="product_id" value="<?= $productId ?>">
                        <button type="submit" class="boutonAjouterPanier">Ajouter au Panier</button>
                    </form>
                </div>
            </div>

            <h2>Vous pourriez également aimer</h2>
            <div class="random-products">
                <?php foreach ($randomProducts as $randomProduct): ?>
                    <div class="random-product">
                        <a href="product_detail.php?id=<?= $randomProduct['id'] ?>">
                            <img src="<?= htmlspecialchars($randomProduct['image']) ?>"
                                alt="<?= htmlspecialchars($randomProduct['name']) ?>" class="random-product-image" />
                            <h3><?= htmlspecialchars($randomProduct['name']) ?></h3>
                            <p><?= htmlspecialchars($randomProduct['prix']) ?> €</p>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </main>
    </div>
    <?php include('footer.php'); ?>
</body>

</html>