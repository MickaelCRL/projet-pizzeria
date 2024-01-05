<?php
include("../controller/controllerProduit.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['idProduit'])) {
    $idProduit = $_POST['idProduit'];
    $prixProduit = controllerProduit::getPrixProduit($idProduit); // Obtenez le prix de la pizza à supprimer

    // Trouver l'index de la pizza dans le panier
    $index = array_search($idProduit, $_SESSION['panierProduit']);

    if ($index !== false) {
        if ($_SESSION['tabQuantiteProduit'][$idProduit] > 1) {
            // S'il y a plus d'une pizza de ce type, décrémentez la quantité
            $_SESSION['tabQuantiteProduit'][$idProduit] -= 1;
        } else {
            // S'il n'y a qu'une seule pizza, retirez-la du panier
            unset($_SESSION['panierProduit'][$index]);
            unset($_SESSION['tabQuantiteProduit'][$idProduit]);

        }

        // Mettre à jour le prix total du panier
        $_SESSION['prixTotal'] -= $prixProduit;
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