<?php
// Vérification si la session est active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Inclusion des contrôleurs nécessaires
include("../controller/controllerPizza.php");

// Vérification de la présence des données attendues
if (isset($_POST['idPizza'], $_POST['recette'])) {
    $idPizza = $_POST['idPizza'];
    $recette = $_POST['recette'];

    // Vérification si la recette existe dans le panier
    if (isset($_SESSION['panierPizzaPersonaliser'][$idPizza])) {
        $indexRecette = array_search($recette, $_SESSION['panierPizzaPersonaliser'][$idPizza]);

        // Si la recette est trouvée dans le panier, la supprimer
        if ($indexRecette !== false) {
            // Mettre à jour le prix total
            $prixRecette = $_SESSION['prixParRecette'][$idPizza][$recette];
            $_SESSION['prixTotal'] -= $prixRecette;

            // Supprimer la recette du panier
            unset($_SESSION['panierPizzaPersonaliser'][$idPizza][$indexRecette]);

            // Réorganiser les clés du tableau
            $_SESSION['panierPizzaPersonaliser'][$idPizza] = array_values($_SESSION['panierPizzaPersonaliser'][$idPizza]);
        }
    }
}

// Redirection vers la page de panier après la suppression
header("Location: ../view/vuePanier.php");
