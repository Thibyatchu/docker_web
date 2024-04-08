<?php
// On démarre une session
session_start();

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
    <title>Détails du produit</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
    <main class="container">
        <div class="row">
            <section class="col-12">
                <h1>Détails du compte</h1>
                <p>ID : <?= $produit['id'] ?></p>
                <p>Identifiant : <?= $produit['identifiant'] ?></p>
                <p>Mot de Passe : <?= $produit['mdp'] ?></p>
                <p><a href="crud.php">Retour</a> <a href="edit.php?id=<?= $produit['id'] ?>">Modifier</a></p>
            </section>
        </div>
    </main>
</body>
</html>