<!DOCTYPE html>
<html>
<head>
    <title>Pizzas</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
    <?php include("../view/menu.php"); ?>
    <main class="mainPizza">
        <?php
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        require_once("../config/connexion.php");
        connexion::connect();
        $pdo = connexion::pdo();
        $requete = "SELECT * FROM VuePizzaProposee";
        $resultat = $pdo->query($requete); 
        if ($resultat->rowCount() > 0) {
            // Parcourir les résultats et afficher les noms des pizzas
            while ($row = $resultat->fetch(PDO::FETCH_ASSOC)) {
                $lien_image = htmlspecialchars($row['lienImage']);
                $nom = htmlspecialchars($row['nomPizza']);
                $allergenes = htmlspecialchars($row['nomAllergene']);

                echo "<div class='pizza-container'>";
                echo "<img src='../$lien_image' alt='Pizza' class='pizza-image'>";
                echo "<p class='pizza-title'>$nom</p>";
                echo "<p class='pizza-allergenes'>Allergènes : $allergenes</p>";
                echo " <div id='pizza-details'>
                <button id='order-button'>
                    Ajouter au panier
                    <img src='../img/shop_icon.png' alt='Shop Icon' id='shop-icon'>
                </button>
            </div> ";
                echo "</div>";
            }
        } else {
            echo "<p class='erreur'>Aucune pizza trouvée.</p>";
        }
        ?>  
        
    </main>


</body>
<br>
<?php include("../view/footer.html"); ?>
</html>