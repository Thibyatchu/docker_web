<?php

// On inclut la connexion à la base
require_once('includes/db.php');
$conn = connect();

// Requête pour récupérer les mangas
$sql = "SELECT Id_Manwha, titre, auteur  FROM manwha ORDER BY Id_Manwha ASC";
$query = $conn->query($sql);
$mangas = $query->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Répertoire de mangas</title>
    <link rel="stylesheet" href="assets/site.css">
</head>
<body>
    <h1>Répertoire de Manwha</h1>
    <div class="log-in-link"> 
        <a href="log_in.php">Connexion admin</a>
    </div>

    <div class="manga-container">
        <?php foreach ($mangas as $manga) : ?>
            <div class="manga">
                <h2><?php echo $manga['titre']; ?></h2>
                <?php
                echo "<img class='img' src='assets/images/img_{$manga['Id_Manwha']}.png'>";
                ?>
                <p><strong>Auteur :</strong> <?php echo $manga['auteur']; ?></p>
                <a href="fiche-manga.php?id=<?php echo $manga['Id_Manwha']; ?>">Voir la fiche</a>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
