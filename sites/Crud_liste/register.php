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
            <input type="password" name="password"><br><br>

            Se connecter :<br>
            <input type="submit" value="Envoyer"><br><br>
            <a href="log_in.php">J'ai deja un compte</a><br><br>
            <?php

                if (!empty($_POST)){

                    include ('includes/db.php');
                    echo "connection";
                    $conn = connect();
    
                    $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
                    // Préparer la requête d'insertion
                    $requete = $conn->prepare("INSERT INTO connexion ( identifiant, mdp) VALUES (:login, :password);");
                    
                    // Récupération des données du formulaire
                    $login = $_POST['login'];
                    $password = $_POST['password'];
                
                    // Liaison des paramètres
                    $requete->bindParam(':login', $login);
                    $requete->bindParam(':password', $password);
                
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
        </form>
    </body>
</html>
