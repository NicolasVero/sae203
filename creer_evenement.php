<?php

    include 'connect_bdd.php';  

    // Creation d'un nouvel événement
    $creerEvenement = $db -> prepare("INSERT INTO sae203_evenements(nom_evenement, date_evenement, nombre_billets, nombre_billets_restants, nombre_billets_reserves) VALUES (:nom_evenement, :date_evenement, :nombre_billets, :nombre_billets_restants, :nombre_billets_reserves)");
    $creerEvenement -> execute(array('nom_evenement' => htmlspecialchars($_POST['nom_evenement']), 'date_evenement' => $_POST['date_evenement'], 'nombre_billets' => $_POST['nombre_billets'], 'nombre_billets_restants' => $_POST['nombre_billets'], 'nombre_billets_reserves' => 0));

    header("Location: accueil_admin.php");

?>