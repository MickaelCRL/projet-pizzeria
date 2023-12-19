<?php
$idPizzeria = 1;
require_once("../config/connexion.php");
connexion::connect();
$pdo = connexion::pdo();
$query = "SELECT a.rue, v.nomVille, v.codePostal 
 FROM Pizzeria AS p 
 JOIN Adresse AS a ON p.idAdresse = a.idAdresse 
 JOIN Ville AS v ON a.idVille = v.idVille 
 WHERE p.idPizzeria = :idPizzeria";
$statement = $pdo->prepare($query);
$statement->bindParam(':idPizzeria', $idPizzeria, PDO::PARAM_INT);
$statement->execute();
$pizzeriaAddress = $statement->fetch(PDO::FETCH_ASSOC);
if ($pizzeriaAddress) {
    // Crée une chaîne avec les détails de l'adresse
    $addressStringPizzeria = $pizzeriaAddress['rue'] . ', ' . $pizzeriaAddress['nomVille'] . ', ' . $pizzeriaAddress['codePostal'] . ", France";
}
function calculDistancePizzeria($pizzeriaAddress, $destination)
{
    $apiKey = "AIzaSyCezhZK0sYf1t0WMS_x-T9k0IBGR4soPQA";
    $encodedOrigin = urlencode($pizzeriaAddress);
    $encodedDestination = urlencode($destination);

    $url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=metric" .
        "&origins=" . $encodedOrigin .
        "&destinations=" . $encodedDestination .
        "&key=" . $apiKey;

    $jsonString = file_get_contents($url);
    $jsonObject = json_decode($jsonString, true);

    if (isset($jsonObject['rows'][0]['elements'][0]['duration']['value'])) {
        $travelTime = $jsonObject['rows'][0]['elements'][0]['duration']['value'] / 60; // Convertir le temps de trajet en minutes
        return $travelTime;
    } else {
        return -1; // Valeur par défaut si le calcul échoue
    }
}

?>