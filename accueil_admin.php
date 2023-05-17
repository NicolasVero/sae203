<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link href="style.css" rel="stylesheet"/>
    <title>Gestion des billets</title>
</head>
<body>

    <?php 
        //session_set_cookie_params(0);
        session_start();

        if(!isset($_SESSION['mail'])) 
            header("Location: index.php"); 
    ?>

    <h1>Gestion des billets</h1>

    <a href="accueil.php" class="enlever_sous_lignage"><div class="bouton deconnecter" style="width: 250px;"><p>Retour à la page d'accueil</p></div></a>
    <a href="gerer_utilisateurs.php" class="enlever_sous_lignage"><div class="bouton gerer" style="width: 250px;"><p>Gerer les utilisateurs</p></div></a>
    

    <section id="rajouter">
        <fieldset>
            <legend>Creation d'événements</legend>

                <form action="creer_evenement.php" method="POST">

                    Nom de l'événement :
                    <input type="mail" name="nom_evenement" id="nom_evenement" required>

                    <br/>Date de l'événement : 
                    <input type="date" name="date_evenement" id="date_evenement" required>

                    <br/>Nombre de billets à créer : 
                    <input type="number" name="nombre_billets" id="nombre_billets" min="1" required>

                    <br/>
                    <input style="margin-top: 50px;" type="submit" value="Creer l'événement">
                </form>

        </fieldset>
    </section>

    <section id="enlever">
        <fieldset>
            <legend>Modifier l'événement</legend>

                <form action="modifier_evenement.php" method="POST">

                    Identifiant de l'événement
                    <select name="id_evenement" id="id_evenement">
                        <?php
                        
                            include 'connect_bdd.php';
            
                            $schema = $db -> prepare('SELECT id, nom_evenement FROM sae203_evenements');
                            $schema -> execute();

                            while($evenement = $schema -> fetch() )
                                echo '<option value=' . $evenement['id'] . '>' . $evenement['id'] . " - " . $evenement['nom_evenement'] . '</option>';
                        
                        ?>
                    </select>

                    <br/><br/>Nom de l'événement :
                    <input type="mail" name="nom_evenement" id="nom_evenement">
                    
                    <br/>Date de l'événement : 
                    <input type="date" name="date_evenement" id="date_evenement">

                    <br/>Nombre de place : 
                    <input type="number" name="nombre_billets" id="nombre_billets">

                    <br/>
                    <input type="submit" value="Modifier l'événement">
                </form>

        </fieldset>
    </section>


    <?php

        include 'connect_bdd.php';
                
        echo '<section id="consulter">';
        echo "<h2>Evénements pouvant être réservés</h2>";
        
        $schema = $db -> prepare('SELECT * FROM sae203_evenements');
        $schema -> execute();

        while ( $evenement = $schema -> fetch() )
        {
            if($evenement['nombre_billets_restants'] > 0)
                echo '<div class="billets">' . $evenement['nom_evenement'] . ' (ID : ' . $evenement['id'] . ')<br/> ' . $evenement['date_evenement'] . "<br/>" . $evenement['nombre_billets'] . " billets ( " . $evenement['nombre_billets_restants'] . ' restants )<br/><a title="Supprimer ce billet" onclick="return confirmation();" href="gestion_billets.php?id=' . $evenement['id'] . '&supp=' . true . '">Supprimer</a></div>';
            else
                echo '<div class="billets rupture">' . $evenement['nom_evenement'] . ' (ID : ' . $evenement['id'] . ')<br/> ' . $evenement['date_evenement'] . "<br/>" . $evenement['nombre_billets'] . " billets ( " . $evenement['nombre_billets_restants'] . ' restants )<br/><a title="Supprimer ce billet" onclick="return confirmation();" href="gestion_billets.php?id=' . $evenement['id'] . '&supp=' . true . '">Supprimer</a></div>';
        }   

        echo "</section>";
    
    ?>

    <script>

        function confirmation() 
        { 
            return confirm('Etes-vous sûr de vouloir supprimer cet événement ?'); 
        }
        
    </script>

</body>
</html>