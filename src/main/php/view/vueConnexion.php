<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de Connexion</title>
    <link rel="stylesheet" href="../static/css/style.css">
</head>
<?php include("../view/navigation.php"); ?>

<body>
    <form id="form_field" method="post" action="">
        <label for="email">Adresse email : </label>
        <input type="mail" name="email" required><br>

        <label for="mot_de_passe">Mot de passe : </label>
        <input type="password" name="mot_de_passe" required><br>

        <input type="submit" value="Se connecter" id="connexion_button">
    </form>
    <br>
    <a href="inscription.php" id="lien_visible"> Pas encore de compte ? </a>
</body>
<?php include("../view/footer.html"); ?>

</html>
<?php
include("../controller/controllerClient.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $mot_de_passe = $_POST["mot_de_passe"];


    $resultat = controllerClient::connexionCompteClient($email, $mot_de_passe);
    if ($resultat->rowCount() == 0) {
        echo "<p class='erreur'> Il n'existe aucun compte avec cette adresse email. Veuillez vérifier vos informations.</p>";
    } else {
        $utilisateur = $resultat->fetch(PDO::FETCH_ASSOC);

        if (password_verify($mot_de_passe, $utilisateur["motDePasse"])) {
            session_start();
            $_SESSION["idCompteClient"] = $utilisateur["idCompteClient"];
            $_SESSION["nom"] = $utilisateur["nomClient"];
            $_SESSION["prenom"] = $utilisateur["prenomClient"];
            $_SESSION["panier"] = array();
            $_SESSION["prixTotal"] = 0;
            header('Location: ../view/vueEspaceCompte.php');
        } else {
            echo "<p class='erreur'> Échec de la connexion. Vérifiez votre mot de passe. </p>";
        }

    }
}


?>