<!DOCTYPE html>
<html>

<head>
    <title>Création d'une pizza</title>
    <link rel="stylesheet" type="text/css" href="../static/css/style.css">
</head>

<body>
    <?php include("../view/navigation.php"); ?>

    <form enctype="multipart/form-data" id="form_field" method="POST" action="../actions/creationPizza.php">
        <label for="nom">Nom de la pizza :</label>
        <input type="text" id="nom" name="nom" required>

        <label for="image">Image de la pizza :</label>
        <input type="file" name="fileToUpload" id="fileToUpload" accept="image/jpeg, image/png, image/gif" required>

        <label for="alergenes">Liste des allergènes: </label>
        <p>Les allergènes doivent être séparés par des <strong> virgules </strong>.</p>
        <input type="text" id="alergene" name="alergenes" required>

        <?php
        include("../controller/controllerIngredient.php");
        $resultat = controllerIngredient::getIngredientForDisplay();
        if ($resultat->rowCount() > 0) {
            while ($row = $resultat->fetch(PDO::FETCH_ASSOC)) {
                $id = htmlspecialchars($row['idIngredient']);
                $nom = htmlspecialchars($row['nomIngredient']);
                echo "<label for='$id'>$nom</label>";
                echo "<input type='checkbox' id='$id' name='ingredient[$id]' value='$id'>";
            }
        } else {
            echo "<p class='erreur'>Aucun ingrédient trouvé.</p>";
        }
        ?>

        <input type="submit" value="Créer la pizza" id="create_account_button">
    </form>

    <?php include("../view/footer.html"); ?>
</body>

</html>
