<?php
require_once 'ProductController.php';
require_once 'ProductView.php';
require_once 'database.php';

session_start();

$productController = new ProductController($database);

$type = isset($_GET['type']) ? $_GET['type'] : null;
$couleur = isset($_GET['couleur']) ? $_GET['couleur'] : null;
$taille = isset($_GET['taille']) ? $_GET['taille'] : null;
$prix_min = isset($_GET['prix_min']) ? (int) $_GET['prix_min'] : null;
$prix_max = isset($_GET['prix_max']) ? (int) $_GET['prix_max'] : null;

$produits = $productController->filterProducts($type, $couleur, $taille, $prix_min, $prix_max);
$productView = new ProductView();
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
  <title>Rich Ricasso - Catalogue</title>
</head>

<body class="sora-font">
  <?php include('header.php'); ?>
  <div class="fenetre">
    <div class="barre">
      <span class="titre-fenetre">Fenêtre Catalogue</span>
      <div class="boutons-fenetre">
        <span class="moins">-</span>
        <span class="ouvrir">[ ]</span>
        <span class="fermer">X</span>
      </div>
    </div>
    <form action="catalogue.php" method="get" class="form-catalogue">
      <div>
        <label for="type">Type de produit :</label>
        <select id="type" name="type">
          <option value="">Tous</option>
          <option value="cravate">Cravate</option>
          <option value="chemise">Chemise</option>
        </select>
      </div>

      <div>
        <label for="couleur">Couleur :</label>
        <select id="couleur" name="couleur">
          <option value="">Toutes</option>
          <option value="bleu">Bleu</option>
          <option value="violet">Violet</option>
          <option value="rose">Rose</option>
          <option value="mauve">Mauve</option>
          <option value="blanc">Blanc</option>
        </select>
      </div>

      <div>
        <label for="taille">Taille :</label>
        <select id="taille" name="taille">
          <option value="">Toutes</option>
          <option value="Unique">Unique</option>
          <option value="44-56">44-56</option>
        </select>
      </div>

      <div>
        <label for="prix_min">Prix minimum :</label>
        <input type="number" id="prix_min" name="prix_min" min="0" step="0.01" />
      </div>

      <div>
        <label for="prix_max">Prix maximum :</label>
        <input type="number" id="prix_max" name="prix_max" min="0" step="0.01" />
      </div>

      <div>
        <input type="submit" value="Filtrer" class="sora-font" />
      </div>
    </form>
    <div class="product-container">
      <?php
      $productView->displayProducts($produits);
      ?>
    </div>
  </div>
  <?php include('footer.php'); ?>
</body>

</html>