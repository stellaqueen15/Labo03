<?php
require_once 'UserController.php';
require_once 'database.php';
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: connexion.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Suppression de Compte</title>
</head>

<body>
    <p>Êtes-vous sûr de vouloir supprimer votre compte ?</p>
    <button id="confirm-delete">Supprimer le compte</button>
    <p id="responseMessage"></p>

    <script>
        document.getElementById('confirm-delete').addEventListener('click', function () {
            const userId = <?= $_SESSION['id']; ?>;
            fetch(`http://localhost:4208/Labo03/api/user/${userId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = 'index.php';
                    } else {
                        document.getElementById('responseMessage').innerText = "Erreur lors de la suppression du compte.";
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    document.getElementById('responseMessage').innerText = "Erreur lors de la connexion.";
                });
        });
    </script>
</body>

</html>