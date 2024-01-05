<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['idPizza'])) {
    $idPizza = $_POST['idPizza'];

    // Trouver l'index de la pizza dans le panier
    $index = array_search($idPizza, $_SESSION['panier']);

    if ($index !== false) {
        if($_SESSION['tabQuantite'][$idPizza] > 1){
            // Retirer la quantité correspondante
        unset($_SESSION['tabQuantite'][$idPizza]);
        }
        else{
        // Retirer la pizza du panier
        unset($_SESSION['panier'][$index]);
        }
        
        // Recalculer le prix total du panier
        $prixPizza = $_POST['prix'];
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
