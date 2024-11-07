<?php
include 'ProductController.php';
require_once 'database.php';
session_start();

$productId = $_GET['id'];

$productController = new ProductController($database);
$product = $productController->getProductById($productId);
$randomProducts = $productController->getRandomProducts(3, $productId);
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
      <?php
      if ($product) {
        echo "<h1>{$product['name']}</h1>";

        echo "<div class='product-container-details'>";

        echo "<div class='product-imagess'>";
        echo "<img id='main-image' src='{$product['image']}' alt='{$product['name']}' class='main-product-image' />";
        echo "<div class='thumbnails'>";
        echo "<img src='{$product['image']}' alt='{$product['name']}' class='thumbnail-image selected-thumbnail' onclick='changeImage(\"{$product['image']}\", this)' />";
        echo "<img src='{$product['image']}' alt='{$product['name']}' class='thumbnail-image' onclick='changeImage(\"{$product['image']}\", this)' />";
        echo "</div>";
        echo "</div>";

        echo "<div class='product-details'>";
        echo "<p><strong>Type:</strong> {$product['type']}</p>";
        echo "<p><strong>Couleur:</strong> {$product['couleur']}</p>";
        echo "<p><strong>Taille:</strong> {$product['taille']}</p>";
        echo "<p><strong>Prix:</strong> {$product['prix']} €</p>";
        echo "<p><strong>Description:</strong> {$product['description']}</p>";
        echo "</div>";

        echo "</div>";

        if ($randomProducts) {
          echo "<h2>Vous pourriez également aimer</h2>";
          echo "<div class='random-products'>";
          foreach ($randomProducts as $randomProduct) {
            echo "<div class='random-product'>";
            echo "<a href='product_detail.php?id={$randomProduct['id']}'>";
            echo "<img src='{$randomProduct['image']}' alt='{$randomProduct['name']}' class='random-product-image' />";
            echo "<h3>{$randomProduct['name']}</h3>";
            echo "<p>{$randomProduct['prix']} €</p>";
            echo "</a>";
            echo "</div>";
          }
          echo "</div>";
        }
      } else {
        echo "<p>Produit non trouvé.</p>";
      }
      ?>
    </main>
  </div>
  <?php include('footer.php'); ?>
  <script>
    function changeImage(imageSrc, element) {
      document.getElementById('main-image').src = imageSrc;

      const thumbnails = document.querySelectorAll('.thumbnail-image');
      thumbnails.forEach(thumbnail => {
        thumbnail.classList.remove('selected-thumbnail');
      });

      element.classList.add('selected-thumbnail');
    }
  </script>
</body>

</html>