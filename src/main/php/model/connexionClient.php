<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de Connexion</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<?php include("../view/menu.php"); ?>
<body>
    <form method="post" action="">
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
// Connexion à la base de données
require_once("../config/connexion.php");
connexion::connect();
$pdo = connexion::pdo();

// Traitement du formulaire de connexion
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $mot_de_passe = $_POST["mot_de_passe"];

    // Requête SQL pour vérifier les informations de connexion
    $requete = "SELECT CompteClient.idCompteClient,CompteClient.motDePasse, Client.nomClient, Client.prenomClient, CompteClient.motDePasse 
    FROM CompteClient
    JOIN Client ON CompteClient.idCompteClient = Client.idCompteClient
    WHERE CompteClient.adresseMail = '$email'";

    $resultat = $pdo->query($requete);
    $resultat = $pdo->query($requete);


if ($resultat) {

    if($resultat->rowCount() == 0){
        echo "<p class='erreur'> Il n'existe aucun compte avec cette adresse email. Veuillez vérifier vos informations.</p>";
    }   
    else{
        $utilisateur = $resultat->fetch(PDO::FETCH_ASSOC);

        if (password_verify($_POST["mot_de_passe"], $utilisateur["motDePasse"])) {
            // User is connected, retrieve information
            session_start();
            $_SESSION["idCompteClient"] = $utilisateur["idCompteClient"];
            $_SESSION["nom"] = $utilisateur["nomClient"];
            $_SESSION["prenom"] = $utilisateur["prenomClient"];
            $_SESSION["panier"] = array();
            $_SESSION["prixTotal"] = 0;
            // Redirect to the home page
            header('Location: espace_compte.php');
            exit();
        }
        else {
            echo "<p class='erreur'> Échec de la connexion. Vérifiez votre mot de passe. </p>";
        }
    }
} else {
    // Handle query execution failure
    echo "Échec de la requête SQL.";
}

}

?>

