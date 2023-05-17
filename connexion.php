<?php

    include 'connect_bdd.php';   

    $schema = $db -> prepare('SELECT * FROM sae203_utilisateurs WHERE mail = :mail');
    $schema -> execute(array('mail' => $_POST['mail']));
    
    $estCorrect = false;

    session_start();
    $_SESSION['mail'] = $_POST['mail'];
    
    while ( $utilisateur = $schema -> fetch() )
    {
        if($utilisateur['mdp'] == hash('md5', $_POST['mdp'], false))
        {
            $_SESSION['id'      ] = $utilisateur['id'      ];
            $_SESSION['mail'    ] = $utilisateur['mail'    ];
            $_SESSION['nom'     ] = $utilisateur['nom'     ];
            $_SESSION['prenom'  ] = $utilisateur['prenom'  ];
            $_SESSION['civilite'] = $utilisateur['civilite'];

            $estCorrect = true;
        }
    }
     
    if($estCorrect)
        header("Location: accueil.php");
    else
        header("Location: index.php");
    
?>