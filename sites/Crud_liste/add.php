<?php
// On démarre une session
session_start();

if($_POST){
    if(isset($_POST['identifiant']) && !empty($_POST['identifiant'])
    && isset($_POST['mdp']) && !empty($_POST['mdp'])){
        // On inclut la connexion à la base
        require_once('includes/db.php');
        $conn = connect();

        // On nettoie les données envoyées
        $produit = strip_tags($_POST['id']);
        $identifiant = strip_tags($_POST['identifiant']);
        $mdp = strip_tags($_POST['mdp']);
        $hashedPassword = password_hash($mdp, PASSWORD_DEFAULT);

        $sql = 'INSERT INTO `connexion` (`identifiant`, `mdp`) VALUES (:identifiant, :mdp);';

        $query = $conn->prepare($sql);

        $query->bindValue(':identifiant', $identifiant, PDO::PARAM_STR);
        $query->bindValue(':mdp', $hashedPassword, PDO::PARAM_STR);

        $query->execute();

        $_SESSION['message'] = "Produit ajouté";
        require_once('includes/close.php');

        header('Location: crud.php');
    }else{
        $_SESSION['erreur'] = "Le formulaire est incomplet";
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un produit</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
    <main class="container">
        <div class="row">
            <section class="col-12">
                <?php
                    if(!empty($_SESSION['erreur'])){
                        echo '<div class="alert alert-danger" role="alert">
                                '. $_SESSION['erreur'].'
                            </div>';
                        $_SESSION['erreur'] = "";
                    }
                ?>
                <h1>Ajouter un compte</h1>
                <form method="post">
                    <div class="form-group">
                        <label for="identifiant">Identifiant</label>
                        <input type="text" id="identifiant" name="identifiant" class="form-control">

                    </div>
                    <div class="form-group">
                        <label for="mdp">Mot de Passe</label>
                        <input type="password" id="mdp" name="mdp" class="form-control">
                    </div>
                    <button class="btn btn-primary">Envoyer</button><br><br>
                    <a href="welcome.php" class="btn btn-primary">Retour au CRUD</a>
                </form>
            </section>
        </div>
    </main>
</body>
</html>