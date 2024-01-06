<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$_SESSION['panier'] = array();
$_SESSION['tabQuantite'] = array();
$_SESSION['panierProduit'] = array();
$_SESSION['tabQuantiteProduit'] = array();
$_SESSION['prixTotal'] = 0;
header('Location: ../view/vueAccueil.php');
?>