<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if(!isset($_SESSION["estGestionnaire"]) || !$_SESSION["estGestionnaire"]){
        header("Location: ../model/connexionClient.php");
    }
    if (isset($_POST['idPizza'])) {
        $idPizza = $_POST['idPizza'];
        include("../controller/controllerPizza.php");
        controllerPizza::ajoutPizzaDuMoment($idPizza);
        header("Location: ../view/vueAccueil.php");
    }
?>