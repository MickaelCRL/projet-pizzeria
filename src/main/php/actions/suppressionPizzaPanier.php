<?php
include("../controller/controllerPizza.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['idPizza'])) {
    $idPizza = $_POST['idPizza'];
    $prixPizza = controllerPizza::getPrixPizza($idPizza); // Obtenez le prix de la pizza à supprimer

    // Trouver l'index de la pizza dans le panier
    $index = array_search($idPizza, $_SESSION['panier']);

    if ($index !== false) {
        if ($_SESSION['tabQuantite'][$idPizza] > 1) {
            // S'il y a plus d'une pizza de ce type, décrémentez la quantité
            $_SESSION['tabQuantite'][$idPizza] -= 1;
        } else {
            // S'il n'y a qu'une seule pizza, retirez-la du panier
            unset($_SESSION['panier'][$index]);
            unset($_SESSION['tabQuantite'][$idPizza]);

        }

        // Mettre à jour le prix total du panier
        $_SESSION['prixTotal'] -= $prixPizza;
    }

    // Redirection vers la vue du panier après la suppression
    header('Location: ../view/vuePanier.php');
    exit();
} else {
    // Redirection en cas de problème
    header('Location: ../view/vuePanier.php');
    exit();
}
?>