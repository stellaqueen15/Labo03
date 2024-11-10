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
        <form action="" method="POST" id="form-modification">
          <label>Nouveau nom</label><br />
          <input type="text" id="nom" name="nom" value="<?= $_SESSION['name']; ?>" /><br /><br />
          <label>Nouvel email</label><br />
          <input type="email" id="email" name="email" value="<?= $_SESSION['email']; ?>" /><br /><br />
          <label>Nouveau mot de passe</label><br />
          <input type="password" id="password" name="password" /><br /><br />
          <input type="submit" id="submit" value="Modifier" />
        </form>
      </div>
    </div>
  </div>
  <?php include('footer.php'); ?>
</body>
<script>
  document.getElementById('submit').addEventListener('click', (event) => {
    event.preventDefault();

    const userId = <?= $_SESSION['id']; ?>;

    const formData = new FormData(document.getElementById('form-modification'));

    const data = {
      nom: formData.get('nom'),
      email: formData.get('email'),
      password: formData.get('password')
    };

    fetch(`http://localhost:4208/Labo03/api/user/${userId}`, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(data)
    })
      .then(response => {
        if (!response.ok) {
          throw new Error(`Erreur HTTP : ${response.status}`);
        }
        return response.json();
      })
      .then(data => {
        console.log('Réponse du serveur :', data);

        if (data.success) {
          alert(data.message);
          window.location.href = 'profil.php';
        } else {
          alert(`Erreur : ${data.message}`);
        }
      })
      .catch(error => {
        console.error('Erreur lors de la soumission du formulaire :', error);
      });
  });
</script>

</html>