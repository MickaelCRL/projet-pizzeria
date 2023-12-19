<!DOCTYPE html>
<html>
<head>
    <title>Création de compte</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
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
        $code_acces = $_POST["code_acces"];

        // Validate form data
        // TODO: Add your validation logic here

        // Validate password and confirmation
        if ($password != $confirm_password) {
            echo "<p class='erreur'> Votre mot de passe et sa confirmation ne correspondent pas. Essayez à nouveau !</p>";
        } else {
            // Connexion à la base de donnée 
            require_once("../config/connexion.php");
            connexion::connect();
            $pdo = connexion::pdo();
            //Vérifier si le compte n'existe pas déjà
            $existingAccountQuery = $pdo->prepare("SELECT idCompteClient FROM CompteClient WHERE adresseMail = :email");
            $existingAccountQuery->bindParam(':email', $email);
            $existingAccountQuery->execute();

            if ($existingAccountQuery->rowCount() > 0) {
                // Le compte existe déjà 
                echo "<p class='erreur'>Un compte avec cette adresse email existe déjà. Veuillez utiliser une autre adresse email.</p>";
                echo "<p class='erreur'> <a href=connexionClient.php id='lien_erreur'> Ou bien, connectez vous. </a>  </p>";
            }
            
            else {
                $nombreAleatoire = rand(100000, 999999);
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO CompteClient (adresseMail, motDePasse) VALUES (:email, :password)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $passwordHash);
                $stmt->execute();
            
                // Récupérer l'idCompteClient 
                $sqlId = "SELECT MAX(idCompteClient) as Id FROM CompteClient";
                $stmtId = $pdo->prepare($sqlId);
                $stmtId->execute();
                $resultId = $stmtId->fetch(PDO::FETCH_ASSOC);
                $Id = $resultId['Id'];
            
                $sql = "INSERT INTO Client (nomClient, prenomClient, telephone, reduction, numeroIdentificationAuPaiementExterne, idCompteClient) VALUES (:nom, :prenom, :telephone, 0, :nombreAleatoire, :Id)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':nom', $nom);
                $stmt->bindParam(':prenom', $prenom);
                $stmt->bindParam(':telephone', $telephone);
                $stmt->bindParam(':nombreAleatoire', $nombreAleatoire);
                $stmt->bindParam(':Id', $Id);
                $stmt->execute();
            
                session_start();
                $_SESSION['nom'] = $nom;
                $_SESSION['prenom'] = $prenom;
                $_SESSION['idCompteClient'] = $Id; 
            
                header('Location: espace_compte.php');
                exit();
            }
    }
}
    // END: PHP code for form submission
    ?>

    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
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
