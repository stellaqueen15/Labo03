<?php
require_once 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email-newsletter'])) {
    $email = filter_var($_POST['email-newsletter'], FILTER_SANITIZE_EMAIL);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $query = $database->prepare('SELECT * FROM abonnements_infolettre WHERE email = ?');
        $query->execute([$email]);
        $existingUser = $query->fetch();

        if (!$existingUser) {
            $stmt = $database->prepare('INSERT INTO abonnements_infolettre (email) VALUES (?)');
            if ($stmt->execute([$email])) {
                $message = "Merci de vous être abonné à notre infolettre !";
            } else {
                $message = "Une erreur est survenue lors de l'inscription. Veuillez réessayer.";
            }
        } else {
            $message = "Cet e-mail est déjà inscrit à notre infolettre.";
        }
    } else {
        $message = "Veuillez entrer une adresse e-mail valide.";
    }
}
?>

<footer>
    <?php if (isset($message)): ?>
        <p style='color: red;'><?= $message ?></p>
    <?php endif; ?>
    <div id="newsletter-section">
        <h3>Abonnez-vous à notre infolettre !</h3>
        <form action="" method="POST">
            <label for="email-newsletter">Votre adresse e-mail :</label>
            <input type="email" id="email-newsletter" name="email-newsletter" placeholder="Entrez votre email" required>
            <input type="submit" value="S'abonner" class="sora-font" />
        </form>
    </div>
    <p>Site créé par Brenda - Copyright</p>
</footer>