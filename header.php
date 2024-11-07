<?php
$isLoggedIn = isset($_SESSION['email']);
?>
<header>
    <menu>
        <a href="index.php">Accueil</a>
        <div class="header-separateur"></div>
        <a href="catalogue.php">Catalogue</a>
        <div class="header-separateur"></div>

        <?php if ($isLoggedIn): ?>
            <a href="profil.php">Profil</a>
            <div class="header-separateur"></div>
            <a href="deconnexion.php">Déconnexion</a>
        <?php else: ?>
            <a href="inscription.php">S'identifier</a>
        <?php endif; ?>
    </menu>
</header>