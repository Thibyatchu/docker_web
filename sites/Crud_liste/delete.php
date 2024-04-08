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
        die();
    }

    $sql = 'DELETE FROM `connexion` WHERE `id` = :id;';

    // On prépare la requête
    $query = $conn->prepare($sql);

    // On "accroche" les paramètre (id)
    $query->bindValue(':id', $id, PDO::PARAM_INT);

    // On exécute la requête
    $query->execute();
    $_SESSION['message'] = "Produit supprimé";
    header('Location: crud.php');
}
else{
    $_SESSION['erreur'] = "URL invalide";
    header('Location: crud.php');
}
?>