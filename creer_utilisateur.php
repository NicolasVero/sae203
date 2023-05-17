<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css"/>
    <title>Creation de compte</title>
</head>
<body>

    <fieldset>
        <legend>Creation de compte</legend>
        <form action="creation_utilisateur.php" method="POST" id="creer_utilisateur">

            M.<input type="radio" name="civilite" id="civilite" value="M." checked> 
			Mme<input type="radio" name="civilite" id="civilite" value="Mme"> 
            
            <br/>Nom
            <input type="text" name="nom" id="nom" required>

            <br/>Prenom
            <input type="text" name="prenom" id="prenom" required>

            <br/>Mail
            <input type="mail" name="mail" id="mail" required>

            <br/>Mot de passe
            <input onchange="test_mdp()" type="password" name="mdp" id="mdp" required>
            <p id="force_mdp"></p>

            <br/>Conformation du mot de passe
            <input type="password" name="c_mdp" id="c_mdp" required>

            <br/>
            <input type="submit" value="S'inscrire">
        </form>
    </fielset>
</body>
</html>

<script>

    function test_mdp()
    {
        let couleur = document.getElementById('mdp');
        let texte   = document.getElementById('force_mdp');

        couleur.style.backgroundColor = force_mdp('couleur'); 
        texte.innerHTML               = force_mdp('texte');

    }

    function force_mdp(type)
    {
        /* La force du mot de passe est calculé en fonction de la variété de caractères utilisés 
        (minuscules, majuscules, caracteres numériques, detectés grâce à l'objet RegExp), ainsi qu'en fonction de la taille du mot de passe 
        
        Pour chaque variété --> force est multiplié par 2 (*8 au final si tous les types de caractères sont utilisés)
        Puis, viens s'additionner à ce score la taille du mot de passe. */

        let mdp = document.getElementById("mdp");
        let contraintes = new Array(new RegExp("[a-z]"), new RegExp("[A-Z]"), new RegExp("[0-9]"));
        let force = 1;

        for(let i = 0; i < contraintes.length; i++)
            if(contraintes[i].test(mdp.value))
                force *= 2;

        force += mdp.value.length;

        if(type == "couleur")
        {
            if(force < 8 ) return "rgba(220, 116, 140, 0.3)";
            if(force < 12) return "rgba(255, 221, 138, 0.3)";
            if(force < 16) return "rgba(253, 255, 138, 0.3)";
            if(force < 20) return "rgba(168, 255, 138, 0.3)";
    
            return "rgba(138, 255, 237, 0.3)"; 
        }
        
        if(type == "texte")
        {
            if(force < 8 ) return "Très faible";
            if(force < 12) return "Faible";
            if(force < 16) return "Moyen";
            if(force < 20) return "Fort";
    
            return "Très fort";
        }
    }

</script>