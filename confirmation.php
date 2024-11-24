<?php
session_start();

if (isset($_GET['success']) && $_GET['success'] == 1) {
    echo "<p>Merci pour votre commande ! Votre commande est en cours de traitement.</p>";
} else {
    echo "<p>Une erreur est survenue. Veuillez réessayer.</p>";
}

