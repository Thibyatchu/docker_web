<?php

// On inclut la connexion à la base
require_once('includes/db.php');
$conn = connect();

// Vérifie si l'ID du personnage est passé en paramètre
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_pers = $_GET['id'];

    // Requête pour récupérer les informations du personnage spécifié par son ID
    $sql = "SELECT nom, surnom, age, espece, etat_actuel, origine, pouvoir_capacite, arme_valkyrie, histoire FROM personnage WHERE id_pers = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id_pers);
    $stmt->execute();
    $personnage = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    // Redirection vers la page d'accueil si l'ID du personnage n'est pas spécifié
    header("Location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Fiche du personnage</title>
        <link rel="stylesheet" href="assets/voir.css">
    </head>
    <body>
        <div class="img">
            <h2><?php echo $personnage['nom']; ?></h2>
            <img src="assets/images/img_<?php echo $id_pers; ?>.png" alt="<?php echo $personnage['nom']; ?>">
            <p><b>Surnom : </b> <?php echo $personnage['surnom']; ?></p>
            <p><b>Age : </b><?php echo $personnage['age']; ?> ans</p>
            <p><b>Espèce : </b><?php echo $personnage['espece']; ?></p>
            <p><b>Etat actuel : </b><?php echo $personnage['etat_actuel']; ?></p>
            <p><b>Origine : </b><?php echo $personnage['origine']; ?></p>
            <p><b>Pouvoir et capacité : </b><?php echo $personnage['pouvoir_capacite']; ?></p>
            <p><b>Arme Valkyrie : </b><?php echo $personnage['arme_valkyrie']; ?></p>
            <p><b>Histoire : </b><?php echo $personnage['histoire']; ?></p>
            <a href="index.php">Retour à la liste des personnages</a>
        </div>
    </body>
</html>
