<?php
// On démarre une session
session_start();

if($_POST){
    if(isset($_POST['login']) && !empty($_POST['login'])
    && isset($_POST['mdp']) && !empty($_POST['mdp'])){
        // On inclut la connexion à la base
        require_once('includes/db.php');
        $conn = connect();

        // On nettoie les données envoyées
        $produit = strip_tags($_POST['id']);
        $login = strip_tags($_POST['login']);
        $mdp = strip_tags($_POST['mdp']);
        $hashedPassword = password_hash($mdp, PASSWORD_DEFAULT);

        $sql = 'INSERT INTO `personnage` (`nom`, `surnom`, `age`, `espece`, `etat_actuel`, `origine`, `pouvoir_capacite`, `arme_valkyrie`, `histoire`) VALUES (:login, :mdp);';

        $query = $conn->prepare($sql);

        $query->bindValue(':login', $login, PDO::PARAM_STR);
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
                <h1>Ajouter un personnage</h1>
                <form method="post">
                    <div class="form-group">
                        <label for="nom">Nom</label>
                        <input type="text" id="nom" name="nom" class="form-control">

                    </div>
                    <div class="form-group">
                        <label for="surnom">Surnom</label>
                        <input type="text" id="surnom" name="surnom" class="form-control">
                    </div>
                    </div>
                    <div class="form-group">
                        <label for="age">Age</label>
                        <input type="text" id="age" name="age" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="espece">Espece</label>
                        <input type="text" id="espece" name="espece" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="etat_actuel">Etat Actuel</label>
                        <input type="text" id="etat_actuel" name="etat_actuel" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="origine">Origine</label>
                        <input type="text" id="origine" name="origine" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="pouvoir_capacite">Pouvoir et Capacite</label>
                        <input type="text" id="pouvoir_capacite" name="pouvoir_capacite" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="arme_valkyrie">Arme des Valkyries</label>
                        <input type="text" id="arme_valkyrie" name="arme_valkyrie" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="histoire">Histoire</label>
                        <input type="text" id="histoire" name="histoire" class="form-control">
                    </div>
                    <button class="btn btn-primary">Envoyer</button><br><br>
                    <a href="crud.php" class="btn btn-primary">Retour à la liste</a>
                </form>
            </section>
        </div>
    </main>
</body>
</html>