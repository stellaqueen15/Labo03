<?php
require_once 'database.php';
require_once 'nettoyage.php';
session_start();

$email = "";
$password_user = "";
$error_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['email']))
    $email = trim(sanitizeString($_POST['email']));
  if (isset($_POST['password']))
    $password_user = trim(sanitizeString($_POST['password']));

  $recupUser = $database->prepare('SELECT * FROM users WHERE email = ?');
  $recupUser->execute(array($email));

  if ($recupUser->rowCount() > 0) {
    $user = $recupUser->fetch();
    if (password_verify($password_user, $user['password'])) {
      $_SESSION['email'] = $email;
      $_SESSION['name'] = $user['name'];
      $_SESSION['password'] = $user['password'];
      $_SESSION['id'] = $user['id'];

      header("Location: index.php");
    } else {
      $error_message = "Mot de passe incorrect.";
    }
  } else {
    $error_message = "Aucun utilisateur trouvé avec cet email.";
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
  <title>Rich Ricasso - Connexion</title>
</head>

<body class="sora-font">
  <?php include('header.php'); ?>
  <div class="fenetre-connexion">
    <div class="barre-connexion">
      <span class="titre-fenetre-connexion">Fenêtre Connexion</span>
      <div class="boutons-fenetre-connexion">
        <span class="moins">-</span>
        <span class="ouvrir">[ ]</span>
        <span class="fermer">X</span>
      </div>
    </div>
    <div class="contenu-connexion">
      <div class="bloc-connexion">
        <h2>Connexion</h2>
        <?php
        if (!empty($error_message)) {
          echo "<p style='color: aqua;'><strong>$error_message</strong></p>";
        }
        ?>
        <form action="" method="post">
          <label>Email</label><br />
          <input type="email" id="email" name="email" required /><br /><br />
          <label>Mot de passe</label><br />
          <input type="password" id="password" name="password" required /><br /><br />
          <input type="submit" value="Se connecter" class="sora-font" />
        </form>
        <a href="inscription.php">S'inscrire</a>
      </div>
    </div>
  </div>
  <?php include('footer.php'); ?>
</body>

</html>