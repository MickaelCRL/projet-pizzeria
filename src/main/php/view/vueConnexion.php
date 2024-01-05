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
    <a href="vueCreationCompte.php" id="lien_visible"> Pas encore de compte ? </a>
</body>
<?php include("../view/footer.html"); ?>

</html>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["mot_de_passe"];

    include_once("../controller/controllerClient.php");
    $resultat = controllerClient::connexionCompteClient($email, $password);   
    if ($resultat) {
        if ($resultat->rowCount() != 0) {
            // Le mot de passe est correct
            $utilisateur = $resultat->fetch(PDO::FETCH_ASSOC);
            session_start();
            $_SESSION["idCompteClient"] = $utilisateur["idCompteClient"];
            $_SESSION["nom"] = $utilisateur["nomClient"];
            $_SESSION["prenom"] = $utilisateur["prenomClient"];
            $_SESSION["panier"] = array();
            $_SESSION["prixTotal"] = 0;
            $_SESSION["estGestionnaire"] = false;
            header('Location: ../view/vueEspaceCompte.php');
        } else {
            $nb = $resultat->rowCount();
            echo $nb;
            echo "<p class='erreur'> Échec de la connexion. Vérifiez votre adresse mail ou votre mot de passe. </p>";
        }
    } else {
        include_once("../controller/controllerGestionnaire.php");
        $resultat = controllerGestionnaire::connexionGestionnaire($email, $password);
        if ($resultat) {
            if ($resultat->rowCount() != 0) {
                // Le mot de passe est correct
                $utilisateur = $resultat->fetch(PDO::FETCH_ASSOC);
                session_start();
                $_SESSION["idGestionnaire"] = $utilisateur["idGestionnaire"];
                $_SESSION["nom"] = $utilisateur["nomGestionnaire"];
                $_SESSION["prenom"] = $utilisateur["prenomGestionnaire"];
                $_SESSION["estGestionnaire"] = true;
                header('Location: ../view/vueEspaceCompte.php');
            } else {
                echo "<p class='erreur'> Compte non trouvé. </p>";
            }
        } else {
            echo "<p class='erreur'> Échec de la connexion. Vérifiez votre adresse mail ou votre mot de passe. </p>";
        }
    }

}


?>