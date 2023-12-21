<!DOCTYPE html>
<html>

<head>
    <title>Création de compte</title>
    <link rel="stylesheet" type="text/css" href="../static/css/style.css">
</head>

<body>
    <?php
    include("../view/navigation.php");
    include("../controller/controllerClient.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $email = $_POST["email"];
        $telephone = $_POST["telephone"];
        $password = $_POST["password"];
        $confirm_password = $_POST["confirm_password"];
        $code_acces = $_POST["code_acces"];
        if ($password != $confirm_password) {
            echo "<p class='erreur'> Votre mot de passe et sa confirmation ne correspondent pas. Essayez à nouveau !</p>";
        } else {
            $resultat = controllerClient::newCompteClient($nom, $prenom, $telephone, $nombreAleatoire, $Id, $password);
            if(!$resultat){
                echo "<p class='erreur'>Un compte avec cette adresse email existe déjà. Veuillez utiliser une autre adresse email.</p>";
                echo "<p class='erreur'> <a href=../view/vueConnexion.php id='lien_erreur'> Ou bien, connectez vous. </a>  </p>";
            }
            else{
                session_start();
                $_SESSION['nom'] = $nom;
                $_SESSION['prenom'] = $prenom;
                $_SESSION['idCompteClient'] = $Id;
                $_SESSION["panier"] = array();
                $_SESSION["prixTotal"] = 0; 
            
                header('Location: ../view/vueEspaceCompte.php');
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

        <label for="code_acces">Code d'accès à la pizzeria (pour les gestionnaires) :</label>
        <input type="text" id="code_acces" name="code_acces">

        <input type="submit" value="Créer son compte" id="create_account_button">
    </form>
</body>
<br>
<?php include("../view/footer.html"); ?>

</html>