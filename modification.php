<?php
require_once 'UserController.php';
require_once 'database.php';
require_once 'nettoyage.php';
session_start();

$userController = new UserController($database);

if (!isset($_SESSION['email'])) {
  header('Location: connexion.php');
  exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nouveauNom = !empty($_POST['nom']) ? trim(sanitizeString($_POST['nom'])) : $_SESSION['name'];
  $nouvelEmail = !empty($_POST['email']) ? trim(sanitizeString($_POST['email'])) : $_SESSION['email'];
  $nouveauMotDePasse = !empty($_POST['password']) ? trim(sanitizeString($_POST['password'])) : $_SESSION['password'];

  if (strlen($nouveauNom) < 3) {
    $error_message = "Le nom doit comporter au moins 3 caractères.";
  } elseif (strlen($nouveauMotDePasse) < 8) {
    $error_message = "Le mot de passe doit comporter au moins 8 caractères.";
  } elseif (strpos($nouveauMotDePasse, ' ') !== false) {
    $error_message = "Le mot de passe ne doit pas contenir d'espaces.";
  } elseif (!filter_var($nouvelEmail, FILTER_VALIDATE_EMAIL)) {
    $error_message = "L'adresse e-mail n'est pas valide.";
  } else {
    $nouveauMotDePasseHash = $_SESSION['password'];

    if ($nouveauMotDePasse) {
      $nouveauMotDePasseHash = password_hash($nouveauMotDePasse, PASSWORD_DEFAULT);
    }

    $userController->updateUser($_SESSION['id'], $nouveauNom, $nouvelEmail, $nouveauMotDePasseHash);

    $_SESSION['name'] = $nouveauNom;
    $_SESSION['email'] = $nouvelEmail;

    header('Location: profil.php');
    exit();
  }
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
  <title>Rich Ricasso - Modifier</title>
</head>

<body class="sora-font">
  <?php include('header.php'); ?>
  <div class="fenetre-connexion">
    <div class="barre-connexion">
      <span class="window-title-connexion">Fenêtre Modification</span>
      <div class="boutons-fenetre-connexion">
        <span class="moins">-</span>
        <span class="ouvrir">[ ]</span>
        <span class="fermer">X</span>
      </div>
    </div>
    <div class="contenu-connexion">
      <div class="bloc-connexion">
        <h2>Modifier</h2>
        <?php
        if (!empty($error_message)) {
          echo "<p style='color: aqua;'><strong>$error_message</strong></p>";
        }
        ?>
        <form action="" method="post">
          <label>Nouveau nom</label><br />
          <input type="text" id="nom" name="nom" /><br /><br />
          <label>Nouvel email</label><br />
          <input type="email" id="email" name="email" /><br /><br />
          <label>Nouveau mot de passe</label><br />
          <input type="password" id="password" name="password" /><br /><br />
          <input type="submit" value="Modifier" />
        </form>
      </div>
    </div>
  </div>
  <?php include('footer.php'); ?>
</body>

</html>