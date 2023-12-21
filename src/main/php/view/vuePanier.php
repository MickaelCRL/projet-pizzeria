<!DOCTYPE html>
<html>
<head>
    <title>Pizzas</title>
    <link rel="stylesheet" type="text/css" href="../static/css/style.css">
</head>
<body>
<?php include("../view/navigation.php"); ?>
<main class="mainPizza">
        <h1> Votre panier </h1>     
        <?php 
        include("../controller/controllerPizza.php");
        $panier = $_SESSION['panier'];

        for ($i = 0; $i < sizeof($panier); $i++) {
           
            $pizzaPanier = controllerPizza::getPizzaPanier($panier[$i]);
            if ($pizzaPanier->rowCount() > 0) {
                // Parcourir les résultats et afficher les pizzas 
                while ($row = $pizzaPanier->fetch(PDO::FETCH_ASSOC)) {
                    $id = htmlspecialchars($row['idPizza']);
                    $lien_image = htmlspecialchars($row['lienImage']);
                    $nom = htmlspecialchars($row['nomPizza']);
                    $allergenes = htmlspecialchars($row['nomAllergene']);   
    
                    echo "<div class='pizza-container'>";
                    echo "<img src='../static/$lien_image' alt='Pizza' class='pizza-image'>";
                    echo "<p id='pizza-title'>$nom</p>";
                    echo "<p class='pizza-allergenes'>Allergènes : $allergenes</p>";
                    controllerPizza::getPrixPizza($id);
                    echo "</div>";
                }
                
    
            } else {
                echo "<p class='erreur'>Votre panier est vide !</p>";
            }
    
        }
        // Afficher le prix total du panier
        $prixTotal = $_SESSION['prixTotal'];
        echo "<br>";
        echo "<p id='prix'> Prix total de votre commande : $prixTotal € </p>";

        ?>
        </main>   
    </body>
    <br>
    <?php include("../view/footer.html"); ?>
    </html>