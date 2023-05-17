<?php

    include 'connect_bdd.php';

    // Modification du nom d'un événement
    if(!empty($_POST['nom_evenement']))
    {
        $maj_evenement = $db -> prepare("UPDATE sae203_evenements SET nom_evenement = :nom_evenement WHERE id = :id");
        $maj_evenement -> execute(array('nom_evenement' => $_POST['nom_evenement'], 'id' => $_POST['id_evenement']));
    }
    
    // Modification de la date d'un événement 
    if(!empty($_POST['date_evenement'])) 
    {
        $maj_evenement = $db -> prepare("UPDATE sae203_evenements SET date_evenement = :date_evenement WHERE id = :id");
        $maj_evenement -> execute(array('date_evenement' => $_POST['date_evenement'], 'id' => $_POST['id_evenement']));
    } 
    
    // Modification du nombre de billet pour un événement
    if(!empty($_POST['nombre_billets'])) 
    {    
        $schema = $db -> prepare("SELECT nombre_billets_reserves FROM sae203_evenements WHERE id = :id");
        $schema -> execute(array('id' => $_POST['id_evenement']));
        $event = $schema -> fetch();

        // Ajustement du nombre de billets disponibles
        if($_POST['nombre_billets'] >= $event['nombre_billets_reserves'])
        {
            // Ajustement du nombre de billets pouvant encore être réservés 
            $maj_evenement = $db -> prepare("UPDATE sae203_evenements SET nombre_billets_restants = :nombre_billets_restants WHERE id = :id");
            $maj_evenement -> execute(array('nombre_billets_restants' => $_POST['nombre_billets'] - $event['nombre_billets_reserves'], 'id' => $_POST['id_evenement']));

            // Ajustement du nombre total de billets disponibles
            $maj_evenement = $db -> prepare("UPDATE sae203_evenements SET nombre_billets = :nombre_billets WHERE id = :id");
            $maj_evenement -> execute(array('nombre_billets' => $_POST['nombre_billets'], 'id' => $_POST['id_evenement']));
        }
    }
    
    header("Location: accueil_admin.php");
    
?>
