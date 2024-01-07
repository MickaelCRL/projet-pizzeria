<?php
require_once("../model/modelContient.php");

class controllerContient
{
    public static function addContient($idCommande, $idPizza, $listeIngredient, $quantitePizzaCommande)
    {
        modelContient::addContient($idCommande, $idPizza, $listeIngredient, $quantitePizzaCommande);
    }
}
?>