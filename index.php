<?php
session_start();
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
  <title>Rich Ricasso</title>
</head>

<body class="sora-font">
  <?php include('header.php'); ?>
  <div class="fenetre">
    <div class="barre">
      <span class="titre-fenetre">Fenêtre Accueil</span>
      <div class="boutons-fenetre">
        <span class="moins">-</span>
        <span class="ouvrir">[ ]</span>
        <span class="fermer">X</span>
      </div>
    </div>
    <div class="contenu-fenetre">
      <div class="logo-et-caroussel">
        <img src="images/logo_RichRicasso.png" alt="" id="logo" />
      </div>
      <main>
        <div class="contenu-main">
          <div class="texte">
            <h2>À propos de Rich Ricasso</h2>
            <p>
              Je suis Rich Ricasso, cravatier et chemisier de renom, passionné par l'art de sublimer la mode à travers
              des pièces intemporelles. Mon aventure a commencé avec une vision simple mais ambitieuse : fusionner
              l'élégance classique avec l'esthétique moderne du vaporwave et du vaporfashion. <br><br>

              Après des années à me perfectionner dans l'art de la confection de cravates et chemises de luxe, j'ai vu
              mon style se propager parmi les connaisseurs de mode du monde entier. Mes créations, caractérisées par des
              tons pastel tels que le bleu ciel, le rose poudré et le violet lavande, ont trouvé leur place dans
              l'univers de l'ultra-luxe, s'adressant à ceux qui recherchent à la fois singularité et
              raffinement.<br><br>

              Aujourd'hui, je souhaite partager cette passion avec un public plus large, en lançant ma boutique en
              ligne. Cette plateforme est dédiée à ma nouvelle gamme d'été en soie unisexe, alliant confort et
              sophistication, tout en restant fidèle à l’esprit de ma marque. Mon objectif est de vous offrir un accès
              direct à des créations à la fois modernes et luxueuses, tout en reflétant mon amour pour
              l’esthétique<br><br>
              vaporwave.

              Bienvenue dans l’univers de Rich Ricasso, où chaque détail compte et où le luxe s’habille de nuances
              pastel pour séduire tous ceux qui osent se démarquer.
            </p>
          </div>
          <div class="caroussel">
            <img class="mySlides" src="images/tie7.webp" />
            <img class="mySlides" src="images/tieX.webp" />
            <img class="mySlides" src="images/tshirt3.webp" />
            <img class="mySlides" src="images/tshirt2.webp" />
          </div>
        </div>
        <div class="photos-accueil">
          <img src="images/tshirt2.webp" alt="" id="premier-image-accueil" />
          <img src="images/tie7.webp" alt="" id="deuxieme-image-accueil" />
          <img src="images/tshirt6.webp" alt="" id="troisieme-image-accueil" />
        </div>
      </main>
    </div>
  </div>
  <?php include('footer.php'); ?>
  <script>
    var slideIndex = 0;
    carousel();

    function carousel() {
      var i;
      var x = document.getElementsByClassName("mySlides");
      for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
      }
      slideIndex++;
      if (slideIndex > x.length) {
        slideIndex = 1;
      }
      x[slideIndex - 1].style.display = "block";
      setTimeout(carousel, 2000);
    }
  </script>
</body>

</html>