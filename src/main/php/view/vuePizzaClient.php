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
                $lien_image = htmlspecialchars($row['lienImage']);
                $nom = htmlspecialchars($row['nomPizza']);
                $allergenes = htmlspecialchars($row['nomAllergene']);
                $prix = controllerPizza::getPrixPizza($id);

                echo "<div class='pizza-container'>";
                echo "<img src='../static/$lien_image' alt='Pizza' class='pizza-image'>";
                echo "<p id='pizza-title'>$nom</p>";
                echo "<p class='pizza-allergenes'>Allergènes : $allergenes</p>";
                echo "<p class='pizza-price'>$prix €</p>";
                echo "<div id='pizza-details'>";
                // Afficher le bouton pour ajouter la pizza au panier
                echo "<form action='../actions/ajoutPizzaPanier.php' method='post'>";
                echo "<input type='hidden' name='idPizza' value='$id'>";
                echo "<input type='hidden' name='prix' value='$prix'>";
                echo "<button type='submit' id='order-button' >Ajouter au panier
        <img src='../static/img/shop_icon.png' alt='Shop Icon' id='shop-icon'>
        </button>";
                echo "</input>";
                // Afficher un message de confirmation ou d'erreur en fonction du contenu du panier 
                if (isset($_GET['idPizza']) && $_GET['idPizza'] == $id && isset($_GET['erreur']) && $_GET['erreur'] == 0) {
                    echo "<p class='confirmation'>Pizza ajoutée au panier.</p>";
                } else if (isset($_GET['idPizza']) && $_GET['idPizza'] == $id && isset($_GET['erreur']) && $_GET['erreur'] == 1) {
                    echo "<p class='erreur'>Pizza déjà dans le panier.</p>";
                }
                echo "</form>";
                echo "</div>";
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