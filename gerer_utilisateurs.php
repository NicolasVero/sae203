<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link href="style.css" rel="stylesheet"/>
    <title>Gerer les utilisateurs</title>
</head>
<body>
    <h1>Gestion des utilisateurs</h1>
    <a href="accueil_admin.php" class="enlever_sous_lignage"><div class="bouton deconnecter" style="width: 375px;"><p>Retour à la page d'accueil administrateur</p></div></a>

    <?php

        include 'connect_bdd.php';

        // Change les droits d'un utilisateur
        if(isset($_GET['id_utilisateur']))
        {
            $schema = $db -> prepare("SELECT id FROM sae203_utilisateurs WHERE id = :id");
            $schema -> execute(array('id' => $_GET['id_utilisateur']));

            $utilisateur = $schema -> fetch();

            // Fait en sorte qu'on ne puisse pas changer le statut du compte admin 
            if($utilisateur['id'] != 1)
            {
                $changerPermissions = $db -> prepare("UPDATE sae203_utilisateurs SET est_admin = :est_admin WHERE id = :id");
                $changerPermissions -> execute(array('est_admin' => $_GET['est_admin'], 'id' => $_GET['id_utilisateur']));
            }
            else
                echo '<script>alert("Vous ne pouvez pas retirer le rôle d\'administrateur à cet utilisateur"); </script>';
        }

        $schema = $db -> prepare("SELECT est_admin, mail, id FROM sae203_utilisateurs");
        $schema -> execute();

        while($utilisateur = $schema -> fetch())
        {
            if($utilisateur['est_admin'] == 1)
            {
                echo "<div class='utilisateurs administrateur'><p title='Administrateur'>" . $utilisateur['mail'] . "</p>";
                echo '<a href="gerer_utilisateurs.php?id_utilisateur=' . $utilisateur['id'] . '&est_admin=' . 0 . '">Enlever les permissions administrateur</a></div>';
            }
            else
            {
                echo "<div class='utilisateurs'><p>" . $utilisateur['mail'] . "</p>";
                echo '<a href="gerer_utilisateurs.php?id_utilisateur=' . $utilisateur['id'] . '&est_admin=' . 1 . '">Donner les permissions administrateur</a></div>';
            }
        }
    ?>

</body>
</html>