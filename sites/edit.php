<?php
// On démarre une session
session_start();

if($_POST){
    if(isset($_POST['id_pers']) && !empty($_POST['id_pers'])
    && isset($_POST['nom']) && !empty($_POST['nom'])
    && isset($_POST['surnom']) && !empty($_POST['surnom'])
    && isset($_POST['age']) && !empty($_POST['age'])
    && isset($_POST['espece']) && !empty($_POST['espece'])
    && isset($_POST['etat_actuel']) && !empty($_POST['etat_actuel'])
    && isset($_POST['origine']) && !empty($_POST['origine'])
    ){
        // On inclut la connexion à la base
        require_once('includes/db.php');
        $conn = connect();

        // On nettoie les données envoyées
        $id_pers = strip_tags($_POST['id_pers']);
        $nom = strip_tags($_POST['nom']);
        $surnom = strip_tags($_POST['surnom']);
        $age = strip_tags($_POST['age']);
        $espece = strip_tags($_POST['espece']);
        $etat_actuel = strip_tags($_POST['etat_actuel']);
        $origine = strip_tags($_POST['origine']);



        $sql = 'UPDATE `personnage` SET `id_pers`=:id, `nom`=:nom, `surnom`=:surnom, `age`=:age, `espece`=:espece, `etat_actuel`=:etat_actuel, `origine`=:origine WHERE `id_pers`=:id;';

        $query = $conn->prepare($sql);

        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->bindValue(':nom', $nom, PDO::PARAM_STR);
        $query->bindValue(':surnom', $surnom, PDO::PARAM_STR);
        $query->bindValue(':age', $age, PDO::PARAM_INT);
        $query->bindValue(':espece', $espece, PDO::PARAM_INT);
        $query->bindValue(':etat_actuel', $etat_actuel, PDO::PARAM_INT);
        $query->bindValue(':origine', $origine, PDO::PARAM_INT);

        $query->execute();

        $_SESSION['message'] = "Produit modifié";
        require_once('includes/close.php');

        header('Location: crud.php');
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

    $sql = 'SELECT * FROM `personnage` WHERE `id_pers` = :id;';

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
        header('Location: crud.php');
    }
}else{
    $_SESSION['erreur'] = "URL invalide";
    header('Location: crud.php');
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
                        <label for="nom">Identifiant</label>
                        <input type="text" id="nom" name="nom" class="form-control" value="<?= htmlspecialchars($produit['nom'])?>">

                    </div>
                    <div class="form-group">
                        <label for="surnom">Mot de passe</label>
                        <input type="text" id="surnom" name="surnom" class="form-control" value="<?= $produit['surnom']?>">
                    </div>
                    <div class="form-group">
                        <label for="age">Age</label>
                        <input type="text" id="age" name="age" class="form-control" value="<?= htmlspecialchars($produit['age'])?>">
                    </div>
                    <div class="form-group">
                        <label for="espece">Espèce</label>
                        <input type="text" id="espece" name="espece" class="form-control" value="<?= htmlspecialchars($produit['espece'])?>">
                    </div>
                    <div class="form-group">
                        <label for="etat_actuel">Etat actuel</label>
                        <input type="text" id="etat_actuel" name="etat_actuel" class="form-control" value="<?= htmlspecialchars($produit['etat_actuel'])?>">
                    </div>        
                    <div class="form-group">
                        <label for="origine">Origine</label>
                        <input type="text" id="origine" name="origine" class="form-control" value="<?= htmlspecialchars($produit['origine'])?>">
                    </div>       
                    <input type="hidden" value="<?= $produit['id_pers']?>" name="id">
                    <button class="btn btn-primary">Envoyer</button>
                </form>
            </section>
        </div>
    </main>
</body>
</html>