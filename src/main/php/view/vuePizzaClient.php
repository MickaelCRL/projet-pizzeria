<!DOCTYPE html>
<html>

<head>
    <title>Pizzas</title>
    <link rel="stylesheet" type="text/css" href="../static/css/style.css">
</head>

<body>
    <?php include("../view/navigation.php"); ?>
    <main class="mainPizza">
        <?php
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        include("../controller/controllerPizza.php");
        $listPizza = controllerPizza::getPizzasForDisplay();
        if ($listPizza->rowCount() > 0) {
            while ($row = $listPizza->fetch(PDO::FETCH_ASSOC)) {
                $id = htmlspecialchars($row['idPizza']);
                $lienImage = htmlspecialchars($row['lienImage']);
                $nom = htmlspecialchars($row['nomPizza']);
                $idAdresse = controllerPizza::getAllergenePizza($id);
                $allergenes = "";
                $prix = controllerPizza::getPrixPizza($id);
                echo "<div class='pizza-container'>";
                echo "<img src='../static/$lienImage' alt='Pizza' class='pizza-image'>";
                echo "<p id='pizza-title'>$nom</p>";
                // Affichage des allergènes
                while ($row = $idAdresse->fetch(PDO::FETCH_ASSOC)) {
                    $allergenes .= htmlspecialchars($row['nomAllergene']) . ", ";
                }
                // Enlever la dernière virgule
                $allergenes = substr($allergenes, 0, -2);
                echo "<p class='pizza-allergenes'>Allergènes : $allergenes</p>";
                echo "<p class='pizza-prix'>Prix : $prix €</p>";
                echo "<div id='pizza-details'>";
                // Afficher le bouton pour ajouter la pizza au panier
                echo "<form action='../actions/ajoutPizzaPanier.php' method='post'>";
                echo "<input type='hidden' name='idPizza' value='$id'>";
                echo "<input type='hidden' name='prix' value='$prix'>";
                echo "<button type='submit' id='order-button' >Ajouter au panier
                <img src='../static/img/shop_icon.png' alt='Shop Icon' id='icon'>
                </button>";

                echo "</input>";
                // Afficher un message de confirmation ou d'erreur en fonction du contenu du panier 
                if (isset($_GET['idPizza']) && $_GET['idPizza'] == $id && isset($_GET['quantite'])) {
                    echo "<p class='confirmation'>Pizza ajoutée au panier.</p>";
                }
                echo "</form>";

                echo "<form action='../view/vueModifierPizza.php' method='get'>";
                echo "<input type='hidden' name='idPizza' value='$id'>";
                echo "<button type='submit' id='order-button' >Personnaliser</button>";
                echo "</input>";
                echo "</form>";

                if (isset($_SESSION["estGestionnaire"]) && $_SESSION["estGestionnaire"]) {
                    echo "<form action='../actions/ajoutPizzaDuMoment.php' method='post'>";
                    echo "<input type='hidden' name='idPizza' value='$id'/>";
                    echo "<button type='submit' id='order-button' >Pizza du moment
                    <img src='../static/img/+.png' alt='Add Icon' id='icon'/> </button>";
                    echo "</form>";
                }
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p class='erreur'>Aucune pizza trouvée.</p>";
        }
        if (isset($_GET['quantite'])) {
            $quantite = $_GET['quantite'];
        } else {
            $quantite = isset($_SESSION['quantite']) ? $_SESSION['quantite'] : 0;
        }
        ?>



    </main>


</body>
<br>
<?php include("../view/footer.html"); ?>

</html>