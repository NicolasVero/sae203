<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link href="style.css" rel="stylesheet"/>
    <title>Identification</title>
</head>
<body>  

    <?php session_start(); ?> 

    <section id="formulaire_inscription">
        <legend>Identification</legend>
        
        <form action="connexion.php" method="POST">
            <input type="mail" name="mail" id="mail" placeholder="mail" value="<?php if(isset($_SESSION['mail'])) echo $_SESSION['mail'] ?>" required>
            <br/>
            <input type="password" name="mdp" id="mdp" placeholder="mot de passe" required>
            <br/>
            <input type="submit" value="Se connecter">
        </form>

        <?php 
            if(isset($_SESSION['mail']))
                echo "<p style='color: red;'>Mail ou mot de passe incorrect</p>";
        
            session_unset();
            session_destroy();
        ?>
        
        <p>Pas encore inscrit ? Cliquez <a href="creer_utilisateur.php">ici</a></p>
    </section>
</body>
</html>