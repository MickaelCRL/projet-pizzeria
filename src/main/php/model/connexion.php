<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de Connexion</title>
</head>
<body>
    <?php include("../view/menu.php"); ?>
    <h2>Connexion</h2>
    <form method="post" action="">
        <label for="email">Adresse email : </label>
        <input type="mail" name="email" required><br>

        <label for="mot_de_passe">Mot de passe : </label>
        <input type="password" name="mot_de_passe" required><br>

        <input type="submit" value="Se connecter">
    </form>
  
</body>
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
    $requete = "SELECT CompteClient.idCompteClient, Client.nomClient, Client.prenomClient 
    FROM CompteClient
    JOIN Client ON CompteClient.idCompteClient = Client.idCompteClient
    WHERE CompteClient.adresseMail = '$email' AND CompteClient.motDePasse = '$mot_de_passe'";

    $resultat = $pdo->query($requete);

    if ($resultat->rowCount() == 1) {
        // L'utilisateur est connecté, récupérer ses informations
        // récupérer son nom et son prénom : 
        $utilisateur = $resultat->fetch(PDO::FETCH_ASSOC);
        session_start();
        $_SESSION["idCompteClient"] = $utilisateur["idCompteClient"];
        $_SESSION["nom"] = $utilisateur["nomClient"];
        $_SESSION["prenom"] = $utilisateur["prenomClient"];
        // Redirection vers la page d'accueil
        header('Location: espace_compte.php');
        exit();

    } else {
        echo "Échec de la connexion. Vérifiez vos informations.";
    }
}

?>

