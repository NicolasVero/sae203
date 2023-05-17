<?php
    
    include 'connect_bdd.php';

    session_start();

    if(estCasParticulier($db) || !isset($_POST['mail']) || $_POST['code'] != $_SESSION['code']) 
        header("Location: creer_utilisateur.php");
    else
    {
        $civilite = ($_POST['civilite'] == 'M.') ? 1 : 2;
    
        $schema = $db -> prepare("INSERT INTO sae203_utilisateurs(mail, mdp, nom, prenom, civilite, est_admin) VALUES (:mail, :mdp, :nom, :prenom, :civilite, :est_admin)");
        $schema -> execute(array('mail' => $_POST['mail'], 'mdp' => hash('md5', $_POST['mdp'], false), 'nom' => htmlspecialchars(strtolower($_POST['nom'])), 'prenom' => htmlspecialchars(strtolower($_POST['prenom'])), 'civilite' => $civilite, 'est_admin' => 0));
        header("Location: index.php");
    }


    function estCasParticulier($db)
    {
        if($_POST['mdp'] != $_POST['c_mdp']) return true;
        
        $schema = $db -> prepare('SELECT mail FROM sae203_utilisateurs WHERE mail = :mail');
        $schema -> execute(array('mail' => $_POST['mail']));

        if($schema -> rowCount() > 0)
            return true;

        return false;
    }

?>
