<?php

// On inclut la connexion à la base
require_once('includes/db.php');
$conn = connect();

// Vérifie si l'ID du personnage est passé en paramètre
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_pers = $_GET['id'];

    // Requête pour récupérer les informations du personnage spécifié par son ID
    $sql = "SELECT nom, surnom, age, espece, etat_actuel, origine, pouvoir_capacite, arme_valkyrie, histoire description FROM personnage WHERE id_pers = :id";
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
    <div class="personnage">
        <h2><?php echo $personnage['nom']; ?></h2>
        <img src="assets/images/img_<?php echo $id_perso; ?>.png" alt="<?php echo $personnage['nom']; ?>">
        <p><strong>Surnom :</strong> <?php echo $personnage['surnom']; ?></p>
        <p><strong>Age :</strong><?php echo $personnage['age']; ?></p>
        <p><strong>Espèce :</strong><?php echo $personnage['espece']; ?></p>
        <p><strong>Etat actuel :</strong><?php echo $personnage['etat_actuel']; ?></p>
        <p><strong>Origine :</strong><?php echo $personnage['origine']; ?></p>
        <p><?php echo $personnage['pouvoir_capacité']; ?></p>
        <p><?php echo $personnage['arme_valkyrie']; ?></p>
        <p><?php echo $personnage['histoire']; ?></p>
        <a href="index.php">Retour à la liste des personnages</a>
    </div>
</body>
</html>
