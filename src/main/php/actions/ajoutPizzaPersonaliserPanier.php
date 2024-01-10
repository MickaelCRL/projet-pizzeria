<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["nom"])) {
    header("Location: ../view/vueConnexion.php");
}
if (isset($_POST['idPizza'])) {
    $idPizza = $_POST['idPizza'];
    $recette = $_POST['recette'];
    $prix = $_POST['prix'];
    $_SESSION['prixTotal'] += $prix;

    // Vérifier si $_SESSION['panierPizzaPersonaliser'][$idPizza] est défini et s'il s'agit d'un tableau
    if (!isset($_SESSION['panierPizzaPersonaliser'][$idPizza]) || !is_array($_SESSION['panierPizzaPersonaliser'][$idPizza])) {
        $_SESSION['panierPizzaPersonaliser'][$idPizza] = [];

    }

    if (!isset($_SESSION['prixParRecette'][$idPizza])) {
        $_SESSION['prixParRecette'][$idPizza] = [];
    }

    $_SESSION['prixParRecette'][$idPizza][$recette] = $prix;

    array_push($_SESSION['panierPizzaPersonaliser'][$idPizza], $recette);
    $_SESSION['prixParRecette'][$recette][] = $prix;
    header("Location: ../view/vuePizzaClient.php?idPizza=$idPizza");
}
?>