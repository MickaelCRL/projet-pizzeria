<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["nom"])) {
    header("Location: ../view/vueConnexion.php");
}
if (isset($_POST['idPizza'])) {
    $idPizza = $_POST['idPizza'];
    $_SESSION['prixTotal'] += $_POST['prix'];
    if (in_array($idPizza, $_SESSION['panier'])) {
        $_SESSION['tabQuantite'][$idPizza] += 1;
        $quantite = $_SESSION['tabQuantite'][$idPizza];
        header("Location: ../view/vuePizzaClient.php?idPizza=$idPizza&quantite=$quantite");
    } else {
        array_push($_SESSION['panier'], $idPizza);
        $_SESSION['tabQuantite'][$idPizza] = 1;
        $quantite = $_SESSION['tabQuantite'][$idPizza];
        header("Location: ../view/vuePizzaClient.php?idPizza=$idPizza&quantite=$quantite");
    }


}
?>