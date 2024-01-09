<!DOCTYPE html>
<html>

<head>
    <title>Création d'un produit</title>
    <link rel="stylesheet" type="text/css" href="../static/css/style.css">
</head>

<body>
    <?php include("../view/navigation.php"); ?>

    <form enctype="multipart/form-data" id="form_field" method="POST" action="../actions/creationProduit.php">
        <label for="nom">Nom du produit :</label>
        <input type="text" id="nom" name="nom" required>

        <label for="image">Image du produit :</label>
        <input type="file" name="fileToUpload" id="fileToUpload" accept="image/jpeg, image/png, image/gif" required>

        <label for="prix">Prix du produit :</label>
        <input type="number" id="prix" name="prix" min="0" step="0.01" required>

        <label for="quantite">Quantite actuelle en stock :</label>
        <input type="number" id="quantite" name="quantite" min="0" step="1" required>


        <input type="submit" value="Créer le produit" id="create_account_button">
    </form>

    <?php include("../view/footer.html"); ?>
</body>

</html>
