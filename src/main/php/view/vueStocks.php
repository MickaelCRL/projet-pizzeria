<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pizza Paradise</title>
    <link rel="stylesheet" href="../static/css/style.css">
</head>

<body>
    <?php include("./navigation.php"); ?>

    <main>
        <?php
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
      
        include("../controller/controllerIngredient.php");
        $listIngredient = controllerIngredient::getIngredientForDisplay();
        if ($listIngredient->rowCount() > 0) {
            while ($row = $listIngredient->fetch(PDO::FETCH_ASSOC)) {
                $id = htmlspecialchars($row['idIngredient']);
                $nom = htmlspecialchars($row['nomIngredient']);
                $quantite = htmlspecialchars($row['quantiteIngredient']);
                $seuilAlerte = htmlspecialchars($row['seuilAlerte']);
                $prix = htmlspecialchars($row['prixIngredient']);
                $quantiteConsommer = htmlspecialchars($row['quantiteConsommer']);

                echo "<div class='pizza-container'>";

                echo "<p id='pizza-title'>$nom</p>";
                echo "<p class='pizza-allergenes'>Quantité en stock : $quantite</p>";
                // Afficher la quantité modifiable de l'ingrédient
                echo "<form action='../actions/modifierQuantiteIngredient.php' method='post'>";
                echo "<input type='number' name='quantite' value='$quantite' min='0' max='10000' required style='width: 25%; text-align: center;'/>";
                echo "<p> Vous recevrez un mail lorsque vous n'aurez plus que <input type='number' name='seuilAlerte' value='$seuilAlerte' min='0' max='10000' required style='width: 25%; text-align: center';/> $nom en stock. </p>";
                echo "<input type='hidden' name='idIngredient' value='$id'/>";
                // Afficher le bouton pour confirmer la modification de quantité de l'ingrédient
                echo "<button type='submit' id='order-button' >Confirmer la modification </button>";

                echo "</form>";

                echo "</div>";
            }
        } else {
            echo "<p class='erreur'>Aucune pizza trouvée.</p>";
        }
        ?>
    </main>

    <footer>
        &copy; 2023-2024 Pizza Paradise. Tous droits réservés.
    </footer>


</body>

</html>