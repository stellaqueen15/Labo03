<?php
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: connexion.php');
    exit();
}

$cart = $_SESSION['cart'] ?? [];
$total = array_sum(array_column($cart, 'prix'));
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
    <title>Rich Ricasso - Panier</title>
</head>

<body class="sora-font">
    <?php include 'header.php'; ?>
    <div class="fenetre">
        <div class="barre">
            <span class="titre-fenetre">Panier</span>
            <div class="boutons-fenetre">
                <span class="moins">-</span>
                <span class="ouvrir">[ ]</span>
                <span class="fermer">X</span>
            </div>
        </div>
        <div>
            <?php if ($cart): ?>
                <ul class="liste-panier">
                    <?php foreach ($cart as $index => $item): ?>
                        <li>
                            <div class="fenetre-panier">
                                <div class="barre-panier">
                                    <span class="titre-fenetre"><?= htmlspecialchars($item['name']) ?></span>
                                    <div class="boutons-fenetre-panier">
                                        <span class="moins">-</span>
                                        <span class="ouvrir">[ ]</span>
                                        <form action="remove_from_cart.php" method="POST" style="display:inline;">
                                            <input type="hidden" name="index" value="<?= $index ?>">
                                            <button type="submit" class="fermer">X</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="conteneur">
                                    <img src="<?= htmlspecialchars($item['image']) ?>"
                                        alt="<?= htmlspecialchars($item['name']) ?>" width="150">
                                    <p><?= htmlspecialchars($item['name']) ?> - <?= htmlspecialchars($item['prix']) ?> €</p>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div class="conteneur-panier">
                    <p class="prix-total">Total : <?= $total ?> €</p>
                    <form action="valide_cart.php" method="POST">
                        <button type="submit" class="boutonValiderPanier">Valider le Panier</button>
                    </form>
                </div>
            <?php else: ?>
                <p>Votre panier est vide.</p>
            <?php endif; ?>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>

</html>