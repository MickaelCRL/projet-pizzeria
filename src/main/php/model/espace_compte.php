<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pizza Paradise</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php include("../view/menu.php"); ?>
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
            <a href="logout.php">
                Se déconnecter           
                <img src="../img/user_icon.png" alt="user icon" id="user-icon">   
            </a>             
        </button>
        <br>
        <button id="modif_button">
            <a href="modification_compte.php">
                Modifier votre compte           
                <img src="../img/user_icon.png" alt="user icon" id="user-icon">   
            </a>             
        </button>
        <br>
        <button id="delete_button" onclick="confirmDelete()">
            <a href="#">
                Supprimer votre compte
                <img src="../img/user_icon.png" alt="user icon" id="user-icon">
            </a>
        </button>
</main>
<script>
        function confirmDelete() {
            var response = confirm("Êtes-vous sûr de vouloir supprimer votre compte ?");
            if (response) {
                // Si l'utilisateur clique sur OK, redirigez-le vers la page de suppression
                window.location.href = "suppression_compte.php";
            } else {}
        }
    </script>
    <?php include("../view/footer.html"); ?>
</body>
</html>