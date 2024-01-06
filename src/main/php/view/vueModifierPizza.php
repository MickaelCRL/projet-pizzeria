<!DOCTYPE html>
<html>

<head>
    <title>Personnaliser Pizza</title>
    <link rel="stylesheet" type="text/css" href="../static/css/style.css">
    <link rel="stylesheet" type="text/css" href="../static/css/vueModifierPizza.css">
</head>

<body>
    <?php include("../view/navigation.php"); ?>
    <main class="mainPizza">
        <?php
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        include("../controller/controllerPizza.php");
        include("../controller/controllerIngredient.php");
        $idPizza = $_GET['idPizza'];
        $pizza = controllerPizza::getPizzaPanier($idPizza);

        if ($pizza->rowCount() > 0) {
            $row = $pizza->fetch(PDO::FETCH_ASSOC);
            $nomPizza = htmlspecialchars($row['nomPizza']);
            $lienImage = htmlspecialchars($row['lienImage']);
            // Récupérer la liste des ingrédients de la pizza personnalisée
            $ingredientsPizza = controllerPizza::getPizzaIngredient($idPizza);
            ?>

            <div class='pizza-container'>
                <img src='../static/<?php echo $lienImage; ?>' alt='Pizza' class='pizza-image'>
                <p id='pizza-title'>
                    <?php echo $nomPizza; ?>
                </p>

                <!-- Afficher les ingrédients de la pizza personnalisée -->
                <div class='pizza-ingredients'>
                    <h2>Ingrédients de la pizza
                        <?php echo $nomPizza; ?>
                    </h2>
                    <ul>
                        <?php
                        foreach ($ingredientsPizza as $ingredient) {
                            $nomIngredient = htmlspecialchars($ingredient);
                            echo "<li>$nomIngredient<button class='retirer'>-</button></li></li>";
                        }
                        ?>
                    </ul>
                </div>

                <!-- Afficher la liste des autres ingrédients disponibles -->
                <div class='autres-ingredients'>
                    <h2>Autres ingrédients disponibles</h2>
                    <?php
                    $autresIngredients = controllerIngredient::getAutreIngredient($ingredientsPizza);

                    if (count($autresIngredients) > 0) {
                        echo "<ul>";
                        foreach ($autresIngredients as $autreIngredient) {
                            $nomAutreIngredient = $autreIngredient;
                            echo "<li>$nomAutreIngredient<button class='ajouter'>+</button></li>";
                        }
                        echo "</ul>";
                    } else {
                        echo "<p>Aucun autre ingrédient disponible</p>";
                    }
                    ?>
                </div>
            </div>
            <div class="actions">
                <button type="button" class="ajouter-panier-button">Ajouter au panier</button>
            </div>
            <?php
        } else {
            echo "<p class='erreur'>Aucune pizza trouvée.</p>";
        }
        ?>
    </main>
    <?php include("../view/footer.html"); ?>
</body>

</html>