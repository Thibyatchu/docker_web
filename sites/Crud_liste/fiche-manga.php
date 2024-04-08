<?php

// On inclut la connexion à la base
require_once('includes/db.php');
$conn = connect();

// Vérifie si l'ID du manga est passé en paramètre
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_manga = $_GET['id'];

    // Requête pour récupérer les informations du manga spécifié par son ID
    $sql = "SELECT titre, auteur, description FROM manwha WHERE Id_Manwha = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id_manga);
    $stmt->execute();
    $manga = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    // Redirection vers la page d'accueil si l'ID du manga n'est pas spécifié
    header("Location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fiche du manga</title>
    <link rel="stylesheet" href="assets/voir.css">
</head>
<body>
    <div class="manga">
        <h2><?php echo $manga['titre']; ?></h2>
        <img src="assets/images/img_<?php echo $id_manga; ?>.png" alt="<?php echo $manga['titre']; ?>">
        <p><strong>Auteur :</strong> <?php echo $manga['auteur']; ?></p>
        <p><?php echo $manga['description']; ?></p>
        <a href="index.php">Retour à la liste des mangas</a>
    </div>
</body>
</html>
