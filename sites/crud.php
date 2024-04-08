<?php
// Vérifier si l'utilisateur est connecté
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: log_in.php"); // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    exit();
}

// On inclut la connexion à la base
require_once('includes/db.php');
$conn = connect();

$sql = 'SELECT * FROM personnage';

// On prépare la requête
$query = $conn->prepare($sql);

// On exécute la requête
$query->execute();

// On stocke le résultat dans un tableau associatif
$result = $query->fetchAll(PDO::FETCH_ASSOC);

// Fermer la connexion à la base de données
$conn = null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des produits</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <script>
        function confirmDelete(id) {
            var result = confirm("Êtes-vous sûr de vouloir supprimer ce produit ?");
            if (result) {
                window.location.href = 'delete.php?id=' + id;
            }
        }
    </script>
</head>
<body>
    <main class="container">
        <div class="row">
            <section class="col-12">
                <h1>Liste des Personnages</h1>
                <table class="table">
                    <thead>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Surnom</th>
                        <th>Age</th>
                        <th>Espèce</th>
                        <th>Etat actuel</th>
                        <th>Origine</th>
                        <th>Pouvoir et Capacité</th>
                        <th>Arme des Valkyries</th>
                        <th>Histoire</th>
                    </thead>
                    <tbody>
                        <?php
                        // On boucle sur la variable $result
                        foreach($result as $personnage){
                        ?>
                            <tr>
                                <td><?= $personnage['id_pers'] ?></td>
                                <td><?= $personnage['nom'] ?></td>
                                <td><?= $personnage['surnom'] ?></td>
                                <td><?= $personnage['age'] ?></td>
                                <td><?= $personnage['espece'] ?></td>
                                <td><?= $personnage['etat_actuel'] ?></td>
                                <td><?= $personnage['origine'] ?></td>
                                <td><?= $personnage['pouvoir_capacite'] ?></td>
                                <td><?= $personnage['arme_valkyrie'] ?></td>
                                <td><?= $personnage['histoire'] ?></td>
                                <td><a href="edit.php?id=<?= $personnage['id_pers'] ?>">Modifier</a> <button class="btn btn-danger" onclick="confirmDelete(<?= $personnage['id_pers'] ?>)">Supprimer</button></td>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <a href="add.php" class="btn btn-primary">Ajouter un compte</a>
                <br><br>
                <a href="logout.php">Déconnexion</a>
            </section>
        </div>
    </main>
</body>
</html>
