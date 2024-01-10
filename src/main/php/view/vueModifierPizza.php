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
                <form id='ingredient-form' action='#' method='post'>
                    <!-- Afficher les ingrédients de la pizza personnalisée -->
                    <div class='ingredients'>
                        <h2>Ingrédients de la pizza
                            <?php echo $nomPizza; ?>
                        </h2>
                        <ul>
                            <?php
                            echo "<ul>";
                            foreach ($ingredientsPizza as $ingredient) {
                                $nomIngredient = htmlspecialchars($ingredient);
                                $checked = isset($_POST['ingredient']) && in_array($nomIngredient, $_POST['ingredient']) || !isset($_POST['ingredient']) ? 'checked' : '';
                                echo "<li><label><input type='checkbox' name='ingredient[]' value='$nomIngredient' $checked>$nomIngredient</label></li>";
                            }
                            echo "</ul>";
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
                                $checkedAutreIngredient = isset($_POST['ingredient']) && in_array($autreIngredient, $_POST['ingredient']) ? 'checked' : '';
                                echo "<li><label><input type='checkbox' name='ingredient[]' value='$autreIngredient' $checkedAutreIngredient>$autreIngredient</label></li>";
                            }
                            echo "</ul>";
                        } else {
                            echo "<p>Aucun autre ingrédient disponible</p>";
                        }
                        ?>
                    </div>
                    <button type='submit' name='enregistrer'>Enregistrer</button>
                </form>
            </div>
            <div class="actions">
                <?php
                $prix = 0;
                $recette = '';
                $enregistrerClique = false;

                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['enregistrer'])) {
                    $recette = isset($_POST['ingredient']) ? implode(", ", $_POST['ingredient']) : '';
                    $enregistrerClique = true;

                    foreach ($_POST['ingredient'] as $nomIngredient) {
                        $prix += controllerIngredient::getPrixByNomIngredient($nomIngredient);
                    }
                }

                $id = $_GET['idPizza'];
                echo "<p class='pizzaPersonnaliser-prix'>Prix pizza personnaliser: $prix €</p>";

                echo "<form action='../actions/ajoutPizzaPersonaliserPanier.php' method='post'>";
                echo "<input type='hidden' name='idPizza' value='$id'>";
                echo "<input type='hidden' name='prix' value='$prix'>";
                echo "<input type='hidden' name='recette' value='$recette'>";

                // Vérifie si des modifications ont été enregistrées avant d'ajouter au panier
                if ($enregistrerClique) {
                    echo "<button type='submit' id='order-button'>Ajouter au panier
        <img src='../static/img/shop_icon.png' alt='Shop Icon' id='icon'>
    </button>";
                } else {
                    echo "<button type='button' id='order-button' onclick=\"alert('Veuillez enregistrer vos modifications avant d\'ajouter au panier.')\">
        Ajouter au panier
        <img src='../static/img/shop_icon.png' alt='Shop Icon' id='icon'>
    </button>";
                }

                echo "</form>";
                ?>
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