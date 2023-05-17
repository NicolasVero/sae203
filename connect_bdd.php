<?php


    try
    {
        $db = new PDO( 'mysql:host=localhost; dbname=db-veronic', 'usr-veronic', '9pIyUVIl3X', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION] );
        // $db = new PDO( 'mysql:host=localhost; dbname=sae203_db-veronic', 'usr-veronic2', '9pIyUVIl3X', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION] );
    } catch (Exception $e) { die( 'Erreur : ' . $e -> getMessage() ); }

?>