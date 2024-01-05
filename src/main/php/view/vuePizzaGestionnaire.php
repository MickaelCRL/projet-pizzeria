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
        if (isset($_SESSION["estGestionnaire"]) && $_SESSION["estGestionnaire"]) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            echo "<div style='text-align: center; padding: 20px;'>";
            echo "<a href='vueCreationPizza.php' style='text-align:center;'>";
            echo "<button type='submit' id='order-button' >Créer une pizza
                    <img src='../static/img/+.png' alt='Add Icon' id='icon'/> </button>";
            echo "</a>";
            echo "</div>";

            include("../controller/controllerPizza.php");
            $listPizza = controllerPizza::getPizzasForDisplay();
            if ($listPizza->rowCount() > 0) {
                while ($row = $listPizza->fetch(PDO::FETCH_ASSOC)) {
                    $id = htmlspecialchars($row['idPizza']);
                    $lien_image = htmlspecialchars($row['lienImage']);
                    $nom = htmlspecialchars($row['nomPizza']);
                    $result = controllerPizza::getAllergenePizza($id);
                    $allergenes = "";
                    $prix = controllerPizza::getPrixPizza($id);
                    echo "<div class='pizza-container'>";
                    echo "<img src='../static/$lien_image' alt='Pizza' class='pizza-image'>";
                    echo "<p id='pizza-title'>$nom</p>";
                    // Affichage des allergènes
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        $allergenes .= htmlspecialchars($row['nomAllergene']) . ", ";
                    }
                    // Enlever la dernière virgule
                    $allergenes = substr($allergenes, 0, -2);
                    echo "<p class='pizza-allergenes'>Allergènes : $allergenes</p>";
                    echo "<p class='pizza-prix'>Prix : $prix €</p>";
                    echo "<div id='pizza-details'>";


                    echo "<form action='../actions/ajoutPizzaDuMoment.php' method='post'>";
                    echo "<input type='hidden' name='idPizza' value='$id'/>";
                    echo "<button type='submit' id='order-button' >Pizza du moment
                    <img src='../static/img/+.png' alt='Add Icon' id='icon'/> </button>";
                    echo "</form>";

                    echo "<form action='../actions/supprimerPizza.php' method='post'>";
                    echo "<input type='hidden' name='idPizza' value='$id'/>";
                    echo "<button type='submit' id='order-button' >Supprimer cette pizza";
                    echo "</form>";

                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<p class='erreur'>Aucune pizza trouvée.</p>";
            }
        } else {
            echo "<p class='erreur'>Vous n'êtes pas gestionnaire.</p>";
        }
        ?>



    </main>


</body>
<br>
<?php include("../view/footer.html"); ?>

</html>