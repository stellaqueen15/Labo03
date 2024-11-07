<?php
class UserView
{
    public function displayUser()
    {
        echo "<p class='nom-user'>" . $_SESSION['name'] . "</p>";
        echo "<p class='email-user'>" . $_SESSION['email'] . "</p>";
        echo "<p class='abonne_infolettre'>" . $_SESSION['abonne_infolettre'] . "</p>";
        echo "<div class='liens-modification'>";
        echo "<a href='modification.php'>Modifier ses informations</a>";
        echo "<a href='suppressionCompte.php'>Supprimer le compte</a>";
        echo "</div>";
    }
}
?>