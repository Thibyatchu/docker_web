<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="assets/formulaire_stylax.css">
    
    </head>
    <body>
        <form method="post" action="log_in.php">
            Utilisateur :<br>
            <input type="text" name="login"><br><br>

            Mot de passe :<br>
            <input type="password" name="mdp"><br><br>

            Se connecter :<br>
            <input type="submit" value="Envoyer"><br><br>
            <a href="register.php">Se créer un compte</a><br><br>
        </form>
        <?php
                if (!empty($_POST)) {
                    // Connexion à la base de données
                    include ('includes/db.php');
                    $conn = connect();

                    // Récupérer les données du formulaire
                    $login = $_POST['login'];
                    $mdp = $_POST['mdp'];

                    // Requête SQL paramétrée pour vérifier l'existence de l'utilisateur
                    $sql = "SELECT login, mdp FROM connexion WHERE login=:login";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':login', $login);
                    $stmt->execute();
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($result && password_verify($mdp, $result['mdp'])) {
                        // Utilisateur authentifié, démarrer une session et rediriger
                        session_start();
                        $_SESSION['login'] = $login;
                        header("location: welcome.php");
                    } else {
                        echo "Nom d'utilisateur ou mot de passe incorrect.";
                    }

                    $conn = null; // Fermez la connexion à la base de données
                }
                ?>
    </body>
</html>