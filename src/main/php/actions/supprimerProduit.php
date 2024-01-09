<?php 
include("../controller/controllerProduit.php");
if(isset($_POST["idProduit"])){
    controllerProduit::deleteProduit($_POST["idProduit"]);
    header("Location: ../view/vueProduitGestionnaire.php");
}
?>