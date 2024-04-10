<?php
// On démarre une session
session_start();
// Est-ce que l'id existe et n'est pas vide dans l'URL
if(isset($_GET['id_pers']) && !empty($_GET['id_pers'])){
    require_once('includes/db.php');
    $conn = connect();

    // On nettoie l'id envoyé
    $id_pers = strip_tags($_GET['id_pers']);

    $sql = 'SELECT * FROM `personnage` WHERE `id_pers` = :id_pers;';

    // On prépare la requête
    $query = $conn->prepare($sql);

    // On "accroche" les paramètre (id)
    $query->bindValue(':id_pers', $id_pers, PDO::PARAM_INT);

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

    $sql = 'DELETE FROM `personnage` WHERE `id_pers` = :id_pers;';

    // On prépare la requête
    $query = $conn->prepare($sql);

    // On "accroche" les paramètre (id)
    $query->bindValue(':id_pers', $id_pers, PDO::PARAM_INT);

    // On exécute la requête
    $query->execute();
    $_SESSION['message'] = "Personnage supprimé";
    header('Location: crud.php');
}
else{
    $_SESSION['erreur'] = "URL invalide";
    header('Location: crud.php');
}
?>