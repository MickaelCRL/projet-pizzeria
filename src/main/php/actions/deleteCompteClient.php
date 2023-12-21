<?php
include("../controller/controllerClient.php");
session_start();
$idCompteClient = $_SESSION["idCompteClient"];
$resultat = controllerClient::deleteCompteClient($idCompteClient);

if ($resultat) {
    session_destroy();
    header('Location: ../view/vueAccueil.php');
    exit();
} else {
    echo "<p class='erreur'> Échec de la requête SQL. </p>";
}

?>