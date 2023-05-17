<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link href="style.css" rel="stylesheet"/>
    <title>Confirmation mail</title>
</head>
<body>
    <?php 

        $code = genererCode(); 
        //header("Location: creer_utilisateur.php");

        if(! envoyerMail($code, $_POST['mail']))
            echo "nop";

        session_start();
        $_SESSION['code'] = $code;


    ?>

    <fieldset>
        <legend>Confirmation de mail</legend>
        <form action="creation_utilisateur.php" method="POST" id="creer_utilisateur">
            
            <h1>Vous avez reçu un code de confirmation par mail
            <br/>
            <input type="number" name="code" id="code" required>

            <br/>
            <input type="submit" value="Soumettre le code">
        </form>
    </fielset>

</body>
</html>


<?php

    function genererCode()
    {
        $code = "";

        for($i = 0; $i < 6; $i++)
            $code .= rand(0,9);

        return $code;
    }

    function envoyerMail($code, $utilisateur)
    {
        $entete   = "From: hello_world@iut-rouen.fr";
        $entete  .= "Content-type: text/html; charset='UTF-8'";

        $message  = "<h1>Bonjour</h1>"; 
        $message .= "<p>$code</p>";

        return mail($utilisateur, "Code de confirmation", $message, $entete);
    }


    //header("Location: creation_utilisateur.php");

?>