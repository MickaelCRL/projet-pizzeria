<!DOCTYPE html>
<html>

<head>
    <title>Modification de compte</title>
    <link rel="stylesheet" type="text/css" href="../static/css/style.css">
</head>

<body>
    <?php
    include("../view/menu.php");
    include("../controller/controllerClient.php");
    controllerClient::verifPassword();
    ?>

    <form id="form_field" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required>

        <label for="prenom">Prénom : </label>
        <input type="text" id="prenom" name="prenom" required>

        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>

        <label for="telephone">Téléphone :</label>
        <input type="text" id="telephone" name="telephone" required>

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>

        <label for="confirm_password">Confirmation de mot de passe :</label>
        <input type="password" id="confirm_password" name="confirm_password" required>

        <input type="submit" value="Modifier son compte" id="create_account_button">
    </form>
</body>
<br>
<?php include("../view/footer.html"); ?>

</html>