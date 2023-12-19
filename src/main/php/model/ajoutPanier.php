<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if(!isset($_SESSION["nom"])){
        header("Location: ../model/connexionClient.php");
    }
    if (isset($_POST['idPizza'])) {
        $idPizza = $_POST['idPizza'];
        if(in_array($_POST['idPizza'], $_SESSION['panier'])){
            header("Location: ../model/pizza.php?idPizza=$idPizza&erreur=1");
        }else{
            array_push($_SESSION['panier'], $idPizza);
            $_SESSION['prixTotal'] += $_POST['prix'];
            header("Location: ../model/pizza.php?idPizza=$idPizza&erreur=0");
        }
    }
?>

    
    