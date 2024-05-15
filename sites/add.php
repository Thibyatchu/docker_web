<?php
// On démarre une session
session_start();


require_once('includes/db.php');

if($_POST){
    if(isset($_POST['nom']) && !empty($_POST['nom'])
    && isset($_POST['surnom']) && !empty($_POST['surnom'])
    && isset($_POST['age']) && !empty($_POST['age'])
    && isset($_POST['espece']) && !empty($_POST['espece'])
    && isset($_POST['etat_actuel']) && !empty($_POST['etat_actuel'])
    && isset($_POST['origine']) && !empty($_POST['origine'])
    && isset($_POST['pouvoir_capacite']) && !empty($_POST['pouvoir_capacite'])
    && isset($_POST['arme_valkyrie']) && !empty($_POST['arme_valkyrie'])
    && isset($_POST['histoire']) && !empty($_POST['histoire'])){
        // On inclut la connexion à la base
        
        $conn = connect();

        // On nettoie les données envoyées
        $nom = strip_tags($_POST['nom']);
        $surnom = strip_tags($_POST['surnom']);
        $age = strip_tags($_POST['age']);
        $espece = strip_tags($_POST['espece']);
        $etat_actuel = strip_tags($_POST['etat_actuel']);
        $origine = strip_tags($_POST['origine']);
        $pouvoir_capacite = strip_tags($_POST['pouvoir_capacite']);
        $arme_valkyrie = strip_tags($_POST['arme_valkyrie']);
        $histoire = strip_tags($_POST['histoire']);
        

        $sql = 'INSERT INTO `personnage` (`nom`, `surnom`, `age`, `espece`, `etat_actuel`, `origine`, `pouvoir_capacite`, `arme_valkyrie`, `histoire`) VALUES (:nom, :surnom, :age, :espece, :etat_actuel, :origine, :pouvoir_capacite, :arme_valkyrie, :histoire);';

        $query = $conn->prepare($sql);

        $query->bindValue(':nom', $nom, PDO::PARAM_STR);
        $query->bindValue(':surnom', $surnom, PDO::PARAM_STR);
        $query->bindValue(':age', $age, PDO::PARAM_STR);
        $query->bindValue(':espece', $espece, PDO::PARAM_STR);
        $query->bindValue(':etat_actuel', $etat_actuel, PDO::PARAM_STR);
        $query->bindValue(':origine', $origine, PDO::PARAM_STR);
        $query->bindValue(':pouvoir_capacite', $pouvoir_capacite, PDO::PARAM_STR);
        $query->bindValue(':arme_valkyrie', $arme_valkyrie, PDO::PARAM_STR);
        $query->bindValue(':histoire', $histoire, PDO::PARAM_STR);

        $result = $query->execute();

        if ($result) {
            // Get the ID of the newly inserted record
            $lastInsertId = $conn->lastInsertId();

            // Upload the file with the ID as its name
            if (isset($_FILES['file'])) {
                $tmpName = $_FILES['file']['tmp_name'];
                $name = $_FILES['file']['name'];
                $size = $_FILES['file']['size'];
                $error = $_FILES['file']['error'];

                // Construct the new filename using the ID
                $newFileName = 'img_' . $lastInsertId . '.png';

                // Move the uploaded file to the desired location with the new filename
                move_uploaded_file($tmpName, 'assets/images/' . $newFileName);
            }

            header("Location: crud.php");
            exit(); // Assurez-vous de sortir du script après la redirection
        } else {
            echo "Erreur lors de la création du block";
        }

        $_SESSION['message'] = "Manwha ajouté";
        require_once('includes/close.php');

        header('Location: crud.php');
    } else {
        $_SESSION['erreur'] = "Le formulaire est incomplet";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un produit</title>

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
                <h1>Ajouter un personnage</h1>
                <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="nom">Nom</label>
                        <input type="text" id="nom" name="nom" class="form-control">

                    </div>
                    <div class="form-group">
                        <label for="surnom">Surnom</label>
                        <input type="text" id="surnom" name="surnom" class="form-control">
                    </div>
                    </div>
                    <div class="form-group">
                        <label for="age">Age</label>
                        <input type="text" id="age" name="age" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="espece">Espece</label>
                        <input type="text" id="espece" name="espece" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="etat_actuel">Etat Actuel</label>
                        <input type="text" id="etat_actuel" name="etat_actuel" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="origine">Origine</label>
                        <input type="text" id="origine" name="origine" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="pouvoir_capacite">Pouvoir et Capacite</label>
                        <input type="text" id="pouvoir_capacite" name="pouvoir_capacite" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="arme_valkyrie">Arme des Valkyries</label>
                        <input type="text" id="arme_valkyrie" name="arme_valkyrie" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="histoire">Histoire</label>
                        <input type="text" id="histoire" name="histoire" class="form-control">
                    </div>
                    <div>
                        <label for="file">Image: </label>
                        <input type="file" name="file">
                    </div>
                    <button class="btn btn-primary">Envoyer</button><br><br>
                    <a href="crud.php" class="btn btn-primary">Retour à la liste</a>
                </form>
            </section>
        </div>
    </main>
</body>
</html>