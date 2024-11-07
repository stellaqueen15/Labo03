<?php
require_once 'database.php';
require_once 'UserView.php';
session_start();

if (!isset($_SESSION['email'])) {
  header('Location: connexion.php');
  exit;
}

$recupInfolettre = $database->prepare('SELECT * FROM abonnements_infolettre WHERE email = ?');
$recupInfolettre->execute(array($_SESSION['email']));

if ($recupInfolettre->rowCount() > 0) {
  $_SESSION['abonne_infolettre'] = "Abonné(e) à l'infolettre";
} else {
  $_SESSION['abonne_infolettre'] = "Non abonné(e) à l'infolettre";
}


$userView = new UserView();
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
  <title>Rich Ricasso - Profil</title>
</head>

<body class="sora-font">
  <?php include('header.php'); ?>
  <div class="fenetre">
    <div class="barre">
      <span class="titre-fenetre">Fenêtre Profil</span>
      <div class="boutons-fenetre">
        <span class="moins">-</span>
        <span class="ouvrir">[ ]</span>
        <span class="fermer">X</span>
      </div>
    </div>
    <div class="contenu-profil">
      <?php
      $userView->displayUser();
      ?>
    </div>
  </div>
  <?php include('footer.php'); ?>
</body>

</html>