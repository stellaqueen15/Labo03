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
    document.addEventListener('DOMContentLoaded', async () => {
      const urlParams = new URLSearchParams(window.location.search);
      const productId = urlParams.get('id');

      const productContainer = document.getElementById('product-detail-container');
      productContainer.innerHTML = '<p>Chargement du produit...</p>';

      try {
        // Effectuer les deux fetchs en parallèle
        const [tailleResponse, produitResponse, produitsAleatoiresResponse] = await Promise.all([
          fetch(`http://localhost:4208/Labo03/api/taille/${productId}`).then(res => res.json()),
          fetch(`http://localhost:4208/Labo03/api/produit/${productId}`).then(res => res.json()),
          fetch('http://localhost:4208/Labo03/api/produitsAle').then(res => res.json())
        ]);

        // Construire la page une fois que tout est chargé
        if (produitResponse) {
          const productDetailHTML = `
        <h1>${produitResponse.name}</h1>
        <div class="product-container-details">
          <div class="product-imagess">
            <img id="main-image" src="${produitResponse.image}" alt="${produitResponse.name}" class="main-product-image" />
            <div class="thumbnails">
              <img src="${produitResponse.image}" alt="${produitResponse.name}" class="thumbnail-image selected-thumbnail" onclick="changeImage('${produitResponse.image}', this)" />
              <img src="${produitResponse.image}" alt="${produitResponse.name}" class="thumbnail-image" onclick="changeImage('${produitResponse.image}', this)" />
            </div>
          </div>
          <div class="product-details">
            <p><strong>Type:</strong> ${produitResponse.type}</p>
            <p><strong>Couleur:</strong> ${produitResponse.couleur}</p>
            <p><strong>Taille:</strong> <span id="sizes-list">${Array.isArray(tailleResponse) ? tailleResponse.join(', ') : tailleResponse.message || 'Aucune taille disponible'}</span></p>
            <p><strong>Prix:</strong> ${produitResponse.prix} €</p>
            <p><strong>Description:</strong> ${produitResponse.description}</p>
          </div>
        </div>
      `;
          productContainer.innerHTML = productDetailHTML;

          // Ajouter les produits aléatoires
          if (produitsAleatoiresResponse && produitsAleatoiresResponse.length > 0) {
            let randomProductsHTML = '<h2>Vous pourriez également aimer</h2>';
            randomProductsHTML += '<div class="random-products">';
            produitsAleatoiresResponse.forEach(randomProduct => {
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
            productContainer.innerHTML += randomProductsHTML;
          }
        } else {
          productContainer.innerHTML = '<p>Produit non trouvé.</p>';
        }
      } catch (error) {
        console.error('Erreur lors de la récupération des données :', error);
        productContainer.innerHTML = '<p>Erreur lors du chargement des données. Veuillez réessayer.</p>';
      }
    });

    // Fonction pour changer l'image principale
    function changeImage(imageSrc, element) {
      const mainImage = document.getElementById('main-image');
      if (mainImage) {
        mainImage.src = imageSrc;
        document.querySelectorAll('.thumbnail-image').forEach(thumbnail => {
          thumbnail.classList.remove('selected-thumbnail');
        });
        element.classList.add('selected-thumbnail');
      }
    }

  </script>
</body>

</html>