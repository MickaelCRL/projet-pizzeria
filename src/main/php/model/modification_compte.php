<!DOCTYPE html>
<html>
<head>
    <title>Modification de compte</title>
    <link rel="stylesheet" type="text/css" href="../static/css/style.css">
</head>
<body>
   

    <?php
    include("../view/menu.php");
    // BEGIN: PHP code for form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $email = $_POST["email"];
        $telephone = $_POST["telephone"];
        $password = $_POST["password"];
        $confirm_password = $_POST["confirm_password"];

        // Validate password and confirmation
        if ($password != $confirm_password) {
            echo "<p class='erreur'> Votre mot de passe et sa confirmation ne correspondent pas. Essayez à nouveau !</p>";
        } else {
            // Connexion à la base de donnée 
            require_once("../config/connexion.php");
            connexion::connect();
            $pdo = connexion::pdo();


            $existingAccountQuery = $pdo->prepare("SELECT idCompteClient FROM CompteClient WHERE adresseMail = :email");
            $existingAccountQuery->bindParam(':email', $email);
            $existingAccountQuery->execute();

            if ($existingAccountQuery->rowCount() > 0) {
                // L'adresse email est déjà utilisée'
                echo "<p class='erreur'>Un compte avec cette adresse email existe déjà. Veuillez utiliser une autre adresse email.</p>";
            }

            else {
                session_start();
                $idCompteClient = $_SESSION["idCompteClient"];          
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                $sql = "UPDATE CompteClient SET CompteClient.adresseMail='$email', CompteClient.motDePasse='$passwordHash' WHERE CompteClient.idCompteClient = $idCompteClient";
                $pdo->exec($sql);
                $sql = "UPDATE Client SET Client.nomClient='$nom', Client.prenomClient='$prenom', Client.telephone='$telephone' WHERE Client.idCompteClient = $idCompteClient";
                $pdo->exec($sql);

                $_SESSION["nom"] = $nom;
                $_SESSION["prenom"] = $prenom;       

                header('Location: espace_compte.php');
                exit();
            }
            
    }
}
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
