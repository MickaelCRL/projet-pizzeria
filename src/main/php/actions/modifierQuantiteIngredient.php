<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if(isset($_SESSION["estGestionnaire"]) && !($_SESSION["estGestionnaire"])){
        header("Location: ../view/vueConnexion.php");
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include_once("../controller/controllerIngredient.php");
        $quantite = $_POST["quantite"];
        $seuilAlerte = $_POST["seuilAlerte"];
        controllerIngredient::updateQuantiteIngredient($_POST["idIngredient"], $quantite);
        controllerIngredient::updateSeuilAlerteIngredient($_POST["idIngredient"], $seuilAlerte);
        echo $_POST["idIngredient"];
        echo $quantite;
        echo $seuilAlerte;
        echo "ouais";
        header("Location: ../view/vueStocks.php");

    }