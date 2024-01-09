<?php
require_once("../model/modelUtilise.php");

class controllerUtilise
{

    public static function addUtilise($idPizza, $idIngredient)
    {
        modelUtilise::addUtilise($idPizza, $idIngredient);
    }
}
?>