<?php
require_once 'UserController.php';
require_once 'database.php';
require_once 'nettoyage.php';
session_start();

if (!isset($_SESSION['email'])) {
  header('Location: connexion.php');
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
        <form action="" method="post" id="form-modification">
          <label>Nouveau nom</label><br />
          <input type="text" id="nom" name="nom" value="<?= $_SESSION['name']; ?>" /><br /><br />
          <label>Nouvel email</label><br />
          <input type="email" id="email" name="email" value="<?= $_SESSION['email']; ?>" /><br /><br />
          <label>Nouveau mot de passe</label><br />
          <input type="password" id="password" name="password" /><br /><br />
          <input type="submit" value="Modifier" />
        </form>
        <p id="responseMessage"></p>
      </div>
    </div>
  </div>
  <?php include('footer.php'); ?>
</body>
<script>
  document.getElementById('form-modification').addEventListener('submit', function (event) {
    event.preventDefault(); // Empêche le rechargement de la page

    const nom = document.getElementById('nom').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    const data = {
      nom: nom,
      email: email,
      password: password
    };

    const userId = <?= $_SESSION['id']; ?>;
    fetch(`http://localhost:4208/Labo03/api/user/${userId}`, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(data)
    })
      .then(response => response.json())
      .then(data => {
        console.log(data);
        if (data.success) {
          document.getElementById('responseMessage').innerText = "Modification réussie !";
        } else {
          document.getElementById('responseMessage').innerText = "Une erreur est survenue, veuillez réessayer.";
        }
      })
      .catch(error => {
        document.getElementById('responseMessage').innerText = "Erreur de connexion, veuillez réessayer.";
        console.error('Erreur:', error);
      });
  });

</script>

</html>