<?php

// On inclut la connexion à la base
require_once('includes/db.php');
$conn = connect();

// Requête pour récupérer les personnages
$sql = "SELECT id_pers, nom, surnom  FROM personnage ORDER BY id_pers ASC";
$query = $conn->query($sql);
$personnage = $query->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Répertoire de personnage</title>
        <link rel="stylesheet" href="assets/site.css">
    </head>
    <body>
        <h1>Répertoire des Personnages</h1>
        <div class="log-in-link"> 
            <a href="log_in.php">Connexion admin</a>
        </div>

        <div class="manga-container">
            <?php foreach ($personnage as $perso) : ?>
                <div class="manga">
                    <h2><a href="fiche-perso.php?id=<?php echo $perso['id_pers']; ?>"><?php echo $perso['surnom']; ?></a></h2>
                    <?php
                    echo "<img class='img' src='assets/images/img_{$perso['id_pers']}.png'>";
                    ?>
                    <p><b>Nom :</b> <?php echo $perso['nom']; ?></p>
                    <a href="fiche-perso.php?id=<?php echo $perso['id_pers']; ?>">Voir la fiche</a>
                </div>
            <?php endforeach; ?>
        </div>
    </body>
</html>
