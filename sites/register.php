<?php

                if (!empty($_POST)){

                    include ('includes/db.php');
                    echo "connection";
                    $conn = connect();
    
                    $_POST['mdp'] = password_hash($_POST['mdp'], PASSWORD_DEFAULT);
    
                    // Préparer la requête d'insertion
                    $requete = $conn->prepare("INSERT INTO connexion ( login, mdp) VALUES (:login, :mdp);");
                    
                    // Récupération des données du formulaire
                    $login = $_POST['login'];
                    $mdp = $_POST['mdp'];
                
                    // Liaison des paramètres
                    $requete->bindParam(':login', $login);
                    $requete->bindParam(':mdp', $mdp);
                
                    // Exécution de la requête
                    $result = $requete->execute(); 
    
                
                    if ($result) {
                        echo "Les données ont été insérées avec succès.";
                        header("location: crud.php");
                    } else {
                        echo "Erreur lors de l'insertion des données.";
                    }
                
                
            } 
        ?>
<!doctype html>
<html lang = "fr">
    <head>
        <meta charset="UTF-8">
        <!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->
        <title>Se créer un compte</title>
        <link rel="stylesheet" href="assets/formulaire_stylax.css">
    
    </head>
    <body>
        <form method="post" action="register.php">
            Login :<br>
            <input type="text" name="login"><br><br>

            Password :<br>
            <input type="password" name="mdp"><br><br>

            Se connecter :<br>
            <input type="submit" value="Envoyer"><br><br>
            <a href="log_in.php">J'ai deja un compte</a><br><br>
        
        </form>
    </body>
</html>
