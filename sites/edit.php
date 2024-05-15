<?php
// On démarre une session
session_start();

if($_POST){
    if(isset($_POST['id_pers']) && !empty($_POST['id_pers'])
    && isset($_POST['nom']) && !empty($_POST['nom'])
    && isset($_POST['surnom']) && !empty($_POST['surnom'])
    && isset($_POST['age']) && !empty($_POST['age'])
    && isset($_POST['espece']) && !empty($_POST['espece'])
    && isset($_POST['etat_actuel']) && !empty($_POST['etat_actuel'])
    && isset($_POST['origine']) && !empty($_POST['origine'])
    && isset($_POST['pouvoir_capacite']) && !empty($_POST['pouvoir_capacite'])
    && isset($_POST['arme_valkyrie']) && !empty($_POST['arme_valkyrie'])
    && isset($_POST['histoire']) && !empty($_POST['histoire'])
    ){
        // On inclut la connexion à la base
        require_once('includes/db.php');
        $conn = connect();

        // On nettoie les données envoyées
        $id_pers = strip_tags($_POST['id_pers']);
        $nom = strip_tags($_POST['nom']);
        $surnom = strip_tags($_POST['surnom']);
        $age = strip_tags($_POST['age']);
        $espece = strip_tags($_POST['espece']);
        $etat_actuel = strip_tags($_POST['etat_actuel']);
        $origine = strip_tags($_POST['origine']);
        $pouvoir_capacite = strip_tags($_POST['pouvoir_capacite']);
        $arme_valkyrie = strip_tags($_POST['arme_valkyrie']);
        $histoire = strip_tags($_POST['histoire']);



        $sql = 'UPDATE `personnage` SET `id_pers`=:id_pers, `nom`=:nom, `surnom`=:surnom, `age`=:age, `espece`=:espece, `etat_actuel`=:etat_actuel, `origine`=:origine, `pouvoir_capacite`=:pouvoir_capacite, `arme_valkyrie`=:arme_valkyrie, `histoire`=:histoire WHERE `id_pers`=:id_pers;';

        $query = $conn->prepare($sql);

        $query->bindValue(':id_pers', $id_pers, PDO::PARAM_INT);
        $query->bindValue(':nom', $nom, PDO::PARAM_STR);
        $query->bindValue(':surnom', $surnom, PDO::PARAM_STR);
        $query->bindValue(':age', $age, PDO::PARAM_STR);
        $query->bindValue(':espece', $espece, PDO::PARAM_STR);
        $query->bindValue(':etat_actuel', $etat_actuel, PDO::PARAM_STR);
        $query->bindValue(':origine', $origine, PDO::PARAM_STR);
        $query->bindValue(':pouvoir_capacite', $pouvoir_capacite, PDO::PARAM_STR);
        $query->bindValue(':arme_valkyrie', $arme_valkyrie, PDO::PARAM_STR);
        $query->bindValue(':histoire', $histoire, PDO::PARAM_STR);


        $query->execute();

        // Gestion de l'image
        if (isset($_FILES['file'])) {
            $tmpName = $_FILES['file']['tmp_name'];
            $name = $_FILES['file']['name'];
            $size = $_FILES['file']['size'];
            $error = $_FILES['file']['error'];

            // Vérifier s'il n'y a pas d'erreur lors du téléchargement
            if ($error === UPLOAD_ERR_OK) {
                // Déplacer le fichier téléchargé vers le répertoire souhaité
                $newFileName = 'img_' . $id . '.png'; // Nom de fichier basé sur l'ID
                move_uploaded_file($tmpName, 'assets/images/' . $newFileName);
            }
        }

        $_SESSION['message'] = "Personnage modifié";
        require_once('includes/close.php');

        header('Location: crud.php');
    }else{
        $_SESSION['erreur'] = "Le formulaire est incomplet";
    }
}

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
    <title>Modifier un personnage</title>

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
                <h1>Modifier un personnage</h1>
                <form method="post">
                    <div class="form-group">
                        <label for="nom">Nom</label>
                        <input type="text" id="nom" name="nom" class="form-control" value="<?= htmlspecialchars($produit['nom'])?>">

                    </div>
                    <div class="form-group">
                        <label for="surnom">Surnom</label>
                        <input type="text" id="surnom" name="surnom" class="form-control" value="<?= htmlspecialchars($produit['surnom'])?>">
                    </div>
                    <div class="form-group">
                        <label for="age">Age</label>
                        <input type="text" id="age" name="age" class="form-control" value="<?= htmlspecialchars($produit['age'])?>">
                    </div>
                    <div class="form-group">
                        <label for="espece">Espèce</label>
                        <input type="text" id="espece" name="espece" class="form-control" value="<?= htmlspecialchars($produit['espece'])?>">
                    </div>
                    <div class="form-group">
                        <label for="etat_actuel">Etat actuel</label>
                        <input type="text" id="etat_actuel" name="etat_actuel" class="form-control" value="<?= htmlspecialchars($produit['etat_actuel'])?>">
                    </div>        
                    <div class="form-group">
                        <label for="origine">Origine</label>
                        <input type="text" id="origine" name="origine" class="form-control" value="<?= htmlspecialchars($produit['origine'])?>">
                    </div>      
                    <div class="form-group">
                        <label for="pouvoir_capacite">Pouvoir et capacité</label>
                        <input type="text" id="pouvoir_capacite" name="pouvoir_capacite" class="form-control" value="<?= htmlspecialchars($produit['pouvoir_capacite'])?>">
                    </div> 
                    <div class="form-group">
                        <label for="arme_valkyrie">Arme Valkyrie</label>
                        <input type="text" id="arme_valkyrie" name="arme_valkyrie" class="form-control" value="<?= htmlspecialchars($produit['arme_valkyrie'])?>">
                    </div> 
                    <div class="form-group">
                        <label for="histoire">Histoire</label>
                        <input type="text" id="histoire" name="histoire" class="form-control" value="<?= htmlspecialchars($produit['histoire'])?>">
                    </div>  
                    <div class="form-group">
                        <label for="file">Image: </label>
                        <input type="file" name="file">
                    </div>
                    <input type="hidden" value="<?= $produit['id_pers']?>" name="id_pers">
                    <button class="btn btn-primary">Envoyer</button><br><br>
                    <a href="crud.php" class="btn btn-primary">Retour à la liste</a>
                </form>
            </section>
        </div>
    </main>
</body>
</html>