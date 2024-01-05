<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["nom"])) {
    header("Location: ../view/vueConnexion.php");
}
if (isset($_POST['idProduit'])) {
    $idProduit = $_POST['idProduit'];
    $_SESSION['prixTotal'] += $_POST['prixProduit'];
    if (in_array($idProduit, $_SESSION['panierProduit'])) {
        $_SESSION['tabQuantiteProduit'][$idProduit] += 1;
        $quantiteProduit = $_SESSION['tabQuantiteProduit'][$idProduit];
        header("Location: ../view/vueProduit.php?idProduit=$idProduit&quantite=$quantiteProduit");
    } else {
        array_push($_SESSION['panierProduit'], $idProduit);
        $_SESSION['tabQuantiteProduit'][$idProduit] = 1;
        $quantite = $_SESSION['tabQuantiteProduit'][$idProduit];
        header("Location: ../view/vueProduit.php?idProduit=$idProduit&quantite=$quantiteProduit");
    }


}
?>