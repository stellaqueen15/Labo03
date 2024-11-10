<?php
require_once 'UserController.php';
require_once 'database.php';
require_once 'nettoyage.php';

session_start();

$userController = new UserController($database);

$nom = "";
$email = "";
$password_user = "";

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = isset($_POST['nom']) ? sanitizeString($_POST['nom']) : '';
    $email = isset($_POST['email']) ? sanitizeString($_POST['email']) : '';
    $password_user = isset($_POST['password']) ? sanitizeString($_POST['password']) : '';

    if (empty($nom) || empty($email) || empty($password_user)) {
        $error_message = "Tous les champs sont obligatoires.";
    } elseif (strlen($nom) < 3) {
        $error_message = "Le nom doit comporter au moins 3 caractères.";
    } elseif (strlen($password_user) < 8) {
        $error_message = "Le mot de passe doit comporter au moins 8 caractères.";
    } elseif (strpos($password_user, ' ') !== false) {
        $error_message = "Le mot de passe ne doit pas contenir d'espaces.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "L'adresse e-mail n'est pas valide.";
    } else {
        $data = [
            'name' => $nom,
            'email' => $email,
            'password' => $password_user,
        ];
        $jsonData = json_encode($data);
        ?>
        <script>
            fetch('http://localhost:4208/Labo03/api/user', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: '<?= $jsonData; ?>'
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = 'connexion.php';
                    } else {
                        document.getElementById('error-message').innerText = data.message;
                    }
                })
                .catch(error => console.error('Erreur lors de l\'inscription:', error));
        </script>
        <?php
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
    <title>Rich Ricasso - Inscription</title>
</head>

<body class="sora-font">
    <?php include('header.php'); ?>
    <div class="fenetre-connexion">
        <div class="barre-connexion">
            <span class="titre-fenetre-connexion">Fenêtre Inscription</span>
            <div class="boutons-fenetre-connexion">
                <span class="moins">-</span>
                <span class="ouvrir">[ ]</span>
                <span class="fermer">X</span>
            </div>
        </div>
        <div class="contenu-connexion">
            <div class="bloc-connexion">
                <h2>Inscription</h2>
                <?php
                if (!empty($error_message)) {
                    echo "<p style='color: aqua;'><strong>$error_message</strong></p>";
                }
                ?>
                <form action="" method="post">
                    <label>Nom</label><br />
                    <input type="text" id="nom" name="nom" required /><br /><br />
                    <label>Email</label><br />
                    <input type="email" id="email" name="email" required /><br /><br />
                    <label>Mot de passe</label><br />
                    <input type="password" id="password" name="password" required /><br /><br />
                    <input type="submit" value="S'inscrire" />
                </form>
                <a href="connexion.php" class="connecter">Se connecter</a>
            </div>
        </div>
    </div>
    <?php include('footer.php'); ?>
</body>

</html>