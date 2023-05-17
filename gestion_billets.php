<?php

    include 'connect_bdd.php';    

    //TODO voir si on peut enlever : session_start();

    if(isset($_GET['annuler']))
    {
        if($_GET['annuler'])
        {
            // Suppression du billet dans la base de données 
            $annuler = $db -> prepare('DELETE FROM sae203_billets WHERE id = :id');
            $annuler -> execute(array('id' => $_GET['id_billet']));
            $billet = $annuler -> fetch();

            // Selection de l'événement 
            $schema = $db -> prepare('SELECT id, nombre_billets_restants, nombre_billets_reserves FROM sae203_evenements WHERE id = :id');
            $schema -> execute(array('id' => $_GET['id_evenement']));
            $event = $schema -> fetch();

            // Incrémentation du nombre de billets disponibles 
            $rajouter_billet = $db -> prepare("UPDATE sae203_evenements SET nombre_billets_restants = :nombre_billets_restants WHERE id = :id");
            $rajouter_billet -> execute(array('nombre_billets_restants' => $event['nombre_billets_restants'] + 1, 'id' => $event['id']));

            $maj_billets_reserves = $db -> prepare("UPDATE sae203_evenements SET nombre_billets_reserves = :nombre_billets_reserves WHERE id = :id");
            $maj_billets_reserves -> execute(array('nombre_billets_reserves' => $event['nombre_billets_reserves'] - 1, 'id' => $event['id']));

            header("Location: accueil.php");
        }
        else
        {
            $schema = $db -> prepare("SELECT * FROM sae203_evenements WHERE id = :id");
            $schema -> execute(array('id' => $_GET['id_evenement']));
            $event = $schema -> fetch();

            if($event['nombre_billets_restants'] > 0)
            {

                $schema = "INSERT INTO sae203_billets(id_utilisateur, id_evenement, nom_evenement, date_evenement) VALUES (:id_utilisateur, :id_evenement, :nom_evenement, :date_evenement)";
                $reserver = $db -> prepare($schema);
                $reserver -> execute(array('id_utilisateur' => $_GET['id_utilisateur'], 'id_evenement' => $event['id'], 'nom_evenement' => $event['nom_evenement'], 'date_evenement' => $event['date_evenement'])); 

                $enlever_billet = $db -> prepare("UPDATE sae203_evenements SET nombre_billets_restants = :nombre_billets_restants WHERE id = :id");
                $enlever_billet -> execute(array('nombre_billets_restants' => $event['nombre_billets_restants'] - 1, 'id' => $event['id']));

                $maj_billets_reserves = $db -> prepare("UPDATE sae203_evenements SET nombre_billets_reserves = :nombre_billets_reserves WHERE id = :id");
                $maj_billets_reserves -> execute(array('nombre_billets_reserves' => $event['nombre_billets_reserves'] + 1, 'id' => $event['id']));
            }

            header("Location: accueil.php");
        }
    }

    if(isset($_GET['supp']))
    {
        $supprimerBillet = $db -> prepare("DELETE FROM sae203_billets WHERE id_evenement = :id_evenement");
        $supprimerBillet -> execute(array ('id_evenement' => $_GET['id'] ));
        
        $supprimerEvenement = $db -> prepare("DELETE FROM sae203_evenements WHERE id = :id");
        $supprimerEvenement -> execute(array ('id' => $_GET['id'] ));

        header("Location: accueil_admin.php");
    }
    
?>