<?php
include("../controller/controllerClient.php");
include("../controller/controllerGestionnaire.php");
session_start();
if($_SESSION["estGestionnaire"]){
    $idGestionnaire = $_SESSION["idGestionnaire"];
    $resultat = controllerGestionnaire::deleteGestionnaire($idGestionnaire);
    echo "gestionnaire";
}
else{
    $idCompteClient = $_SESSION["idCompteClient"];
    $resultat = controllerClient::deleteCompteClient($idCompteClient);
    echo "client";
}

if ($resultat) {
    session_destroy();
    header('Location: ../view/vueAccueil.php');
    exit();
} else {
    echo "<p class='erreur'> Échec de la requête SQL. </p>";
}

?>