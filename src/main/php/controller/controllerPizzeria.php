<?php
include("../model/modelPizzeria.php");
class controllerPizzeria
{

public static function calculDistancePizzeria($destination)
{
    //$pizzeriaAddress = modelPizzeria::getAdresse();
    $pizzeriaAddress = "Avenue des Sciences, Gif-sur-Yvette, 91190, France";
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

}