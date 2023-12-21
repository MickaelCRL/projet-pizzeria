<?php
include("../controller/controllerClient");
session_start();
$idCompteClient = $_SESSION["idCompteClient"];
$resultat = controllerClient::deleteCompteClient($idCompteClient);

if ($resultat) {
    session_destroy();
    header('Location: view/vueAcceuil.php');
    exit();
} else {
    echo "<p class='erreur'> Échec de la requête SQL. </p>";
}

?>