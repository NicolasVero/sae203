<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link href="style.css" rel="stylesheet"/>
    <title>Accueil</title>
</head>
<body>

    <?php
    
        include 'connect_bdd.php';

        session_start();
        if(!isset($_SESSION['mail'])) header("Location: index.php");

        echo "<h1>Bonjour " . ucfirst($_SESSION['prenom']) . "</h1>";

        // Si la personne est administrateur, fait apparaitre un bouton en plus
        if(estAdmin($db))
        {
            ?>
                <section id="gerer">
                    <a href="accueil_admin.php" class="enlever_sous_lignage"><div class="bouton gerer"><p>Gerer</p></div></a>
                </section>
            <?php
        }
    
        //! Mes billets
        $schema = $db -> prepare('SELECT * FROM sae203_billets ORDER BY id_evenement');
        $schema -> execute();

        echo "<h2>Mes billets</h2>";
        echo '<section id="mes_billets">';

        while ( $billet = $schema -> fetch() )
        {
            // Si le billet qui arrive n'est pas identique au precedent, créer une marge pour les séparer
            if($billet['id_utilisateur'] == $_SESSION['id'])
            {
                if(isset($id_precedent))
                    if($id_precedent != $billet['id_evenement'])
                        echo '<div class="retour_ligne"></div>';
                
                echo '<div class="billets mes_billets">' . $billet['nom_evenement'] . "<br/>" . $billet['date_evenement'] . '<br/><a title="Annuler ce billet" href="gestion_billets.php?id_billet=' . $billet['id'] . '&id_evenement=' . $billet['id_evenement'] . '&id_utilisateur=' . $_SESSION['id'] . '&annuler=' . true . '">Annuler la réservation</a></div>';
                $id_precedent = $billet['id_evenement']; 
            }
        }
        
        echo "</section>";

        //! Evénements pouvant être réservés
        echo "<h2 style='margin-top: 100px;'>Evénements pouvant être réservés</h2>";
        echo '<section id="consulter">';        

        $schema = $db -> prepare('SELECT * FROM sae203_evenements WHERE nombre_billets_restants > 0');
        $schema -> execute();

        while ( $evenement = $schema -> fetch() )
            echo '<div class="billets">' . $evenement['nom_evenement'] . "<br/>" . $evenement['date_evenement'] . "<br/>" . $evenement['nombre_billets_restants'] . '<br/><a title="Reserver cet événement" href="gestion_billets.php?id_evenement=' . $evenement['id'] . '&id_utilisateur=' . $_SESSION['id'] . '&annuler=' . false . '">Reserver</a></div>';
        
        echo "</section>";
        
    
    ?>

    <br/>
    <a href="deconnexion.php" class="enlever_sous_lignage"><div class="bouton deconnecter"><p style="clear: both;">Se deconnecter</p></div></a>
</body>
</html>

<?php
 
    function estAdmin($db)
    {
        $schema = $db -> prepare('SELECT id FROM sae203_utilisateurs WHERE mail = :mail AND est_admin = 1');
        $schema -> execute(array('mail' => $_SESSION['mail']));

        if($schema -> rowCount() > 0)
            return true;

        return false;
    }

?>
