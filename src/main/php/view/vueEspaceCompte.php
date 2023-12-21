<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pizza Paradise</title>
    <link rel="stylesheet" href="../static/css/style.css">
    <script src="../static/js/confirmDelete.js"></script>
</head>

<body>
    <?php include("../view/navigation.php"); ?>
    <main>
        <?php
         if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION["nom"])) {
            // Rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
            header("Location: connexionClient.php");
            exit();
        }
            
                
        echo "<p id='texte_basique'>Vous êtes connecté en tant que " . $_SESSION['prenom'] . " " . $_SESSION['nom'] . "</p>"; 
        ?>
        <button id="logout_button">
            <a href="../actions/deconnexion.php">
                Se déconnecter           
                <img src="../static/img/user_icon.png" alt="user icon" id="user-icon">   
            </a>             
        </button>
        <br>
        <button id="modif_button">
            <a href="../view/vueModifierCompte.php">
                Modifier votre compte           
                <img src="../static/img/user_icon.png" alt="user icon" id="user-icon">   
            </a>             
        </button>
        <br>
        <button id="delete_button" onclick="confirmDelete()">
            <a href="#">
                Supprimer votre compte
                <img src="../static/img/user_icon.png" alt="user icon" id="user-icon">
            </a>
        </button>
</main> 
    <?php include("../view/footer.html"); ?>
</body>
</html>