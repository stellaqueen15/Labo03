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
    <main class="page-produits-details" id="product-detail-container">
    </main>
  </div>
  <?php include('footer.php'); ?>
  <script>
    const urlParams = new URLSearchParams(window.location.search);
    const productId = urlParams.get('id');

    fetch(`http://localhost:4208/Labo03/api/produit/${productId}`)
      .then(response => response.json())
      .then(product => {
        if (product) {
          let productDetailHTML = `
        <h1>${product.name}</h1>
        <div class="product-container-details">
          <div class="product-imagess">
            <img id="main-image" src="${product.image}" alt="${product.name}" class="main-product-image" />
            <div class="thumbnails">
              <img src="${product.image}" alt="${product.name}" class="thumbnail-image selected-thumbnail" onclick="changeImage('${product.image}', this)" />
              <img src="${product.image}" alt="${product.name}" class="thumbnail-image" onclick="changeImage('${product.image}', this)" />
            </div>
          </div>
          <div class="product-details">
            <p><strong>Type:</strong> ${product.type}</p>
            <p><strong>Couleur:</strong> ${product.couleur}</p>
            <p><strong>Taille:</strong> ${product.taille}</p>
            <p><strong>Prix:</strong> ${product.prix} €</p>
            <p><strong>Description:</strong> ${product.description}</p>
          </div>
        </div>
      `;

          document.getElementById('product-detail-container').innerHTML = productDetailHTML;

          fetch('http://localhost:4208/Labo03/api/produitsAle')
            .then(response => response.json())
            .then(randomProducts => {
              if (randomProducts && randomProducts.length > 0) {
                let randomProductsHTML = '<h2>Vous pourriez également aimer</h2>';
                randomProductsHTML += '<div class="random-products">';
                randomProducts.forEach(randomProduct => {
                  randomProductsHTML += `
                <div class="random-product">
                  <a href="product_detail.php?id=${randomProduct.id}">
                    <img src="${randomProduct.image}" alt="${randomProduct.name}" class="random-product-image" />
                    <h3>${randomProduct.name}</h3>
                    <p>${randomProduct.prix} €</p>
                  </a>
                </div>
              `;
                });
                randomProductsHTML += '</div>';
                randomProductsHTML += '</div>';
                document.getElementById('product-detail-container').innerHTML += randomProductsHTML;
              }
            })
            .catch(error => {
              console.error('Erreur lors de la récupération des produits aléatoires:', error);
            });
        } else {
          document.getElementById('product-detail-container').innerHTML = "<p>Produit non trouvé.</p>";
        }
      })
      .catch(error => {
        console.error('Erreur lors de la récupération des détails du produit:', error);
        document.getElementById('product-detail-container').innerHTML = "<p>Une erreur est survenue.</p>";
      });

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