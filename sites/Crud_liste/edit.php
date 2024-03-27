<?php
    // On démarre une session
    session_start();
    if($_POST){
        if(isset($_POST['id']) && !empty($_POST['id'])
        && isset($_POST['login']) && !empty($_POST['login'])
        && isset($_POST['mdp']) && !empty($_POST['mdp'])){
            // On inclut la connexion à la base
            require_once('includes/db.php');
            $conn = connect();
            // On nettoie les données envoyées
            $id = strip_tags($_POST['id']);
            $produit = strip_tags($_POST['login']);
            $prix = strip_tags($_POST['mdp']);
            $sql = 'UPDATE `connexion` SET `id`=:id, `login`=:login, `mdp`=:mdp WHERE `id`=:id;';
            $query = $conn->prepare($sql);
            $query->bindValue(':id', $id, PDO::PARAM_INT);
            $query->bindValue(':login', $produit, PDO::PARAM_STR);
            $query->bindValue(':mdp', $prix, PDO::PARAM_STR);
            $query->execute();
            $_SESSION['message'] = "Produit modifié";
            require_once('includes/close.php');
            header('Location: welcome.php');
        }else{
            $_SESSION['erreur'] = "Le formulaire est incomplet";
        }
    }
    // Est-ce que l'id existe et n'est pas vide dans l'URL
    if(isset($_GET['id']) && !empty($_GET['id'])){
        require_once('includes/db.php');
        $conn = connect();
        // On nettoie l'id envoyé
        $id = strip_tags($_GET['id']);
        $sql = 'SELECT * FROM `connexion` WHERE `id` = :id;';
        // On prépare la requête
        $query = $conn->prepare($sql);
        // On "accroche" les paramètre (id)
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        // On exécute la requête
        $query->execute();
        // On récupère le produit
        $produit = $query->fetch();
        // On vérifie si le produit existe
        if(!$produit){
            $_SESSION['erreur'] = "Cet id n'existe pas";
            header('Location: welcome.php');
        }
    }
    else{
        $_SESSION['erreur'] = "URL invalide";
        header('Location: welcome.php');
    }
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Modifier un produit</title>
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
                    <h1>Modifier un compte</h1>
                    <form method="post">
                        <div class="form-group">
                            <label for="login">Identifiant</label>
                            <input type="text" id="login" name="login" class="form-control" value="<?= $produit['login']?>">
                        </div>
                        <div class="form-group">
                            <label for="mdp">Mot de passe</label>
                            <input type="text" id="mdp" name="mdp" class="form-control" value="<?= $produit['mdp']?>">
                        </div>
                        <input type="hidden" value="<?= $produit['id']?>" name="id">
                        <button class="btn btn-primary">Envoyer</button>
                    </form>
                </section>
            </div>
        </main>
    </body>
</html>