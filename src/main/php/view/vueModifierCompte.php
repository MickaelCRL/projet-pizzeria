<!DOCTYPE html>
<html>

<head>
    <title>Modification de compte</title>
    <link rel="stylesheet" type="text/css" href="../static/css/style.css">
</head>

<body>
    <?php include("../view/menu.php"); ?>

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
    <?php
    include("../controller/controllerClient.php");
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $email = $_POST["email"];
        $telephone = $_POST["telephone"];
        $password = $_POST["password"];
        $confirm_password = $_POST["confirm_password"];
        if ($password != $confirm_password) {
            echo "<p class='erreur'> Votre mot de passe et sa confirmation ne correspondent pas. Essayez à nouveau !</p>";
        }
        else {            
            $idCompteClient = $_SESSION["idCompteClient"];
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $resultat = controllerClient::updateCompteClient($idCompteClient, $nom, $prenom, $email, $telephone, $passwordHash);
            if($resultat){
                $_SESSION["nom"] = $nom;
                $_SESSION["prenom"] = $prenom;
                header('Location: vueEspaceCompte.php');
                
            }    
            echo '<script>';
            if ($resultat) {
                echo 'alert("Modification réussie");'; // Affiche une alerte pour indiquer le succès
            } else {
                echo 'alert("Échec de la mise à jour");'; // Affiche une alerte pour indiquer l'échec
            }
            echo '</script>';
            

        }
    }



    ?>
</body>
<br>
<?php include("../view/footer.html"); ?>

</html>