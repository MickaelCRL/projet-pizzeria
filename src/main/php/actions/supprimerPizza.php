<?php 
include("../controller/controllerPizza.php");
if(isset($_POST["idPizza"])){
    controllerPizza::supprimerPizza($_POST["idPizza"]);
    header("Location: ../view/vuePizzaGestionnaire.php");
}
?>