<?php
include("../model/modelIngredient.php");
class controllerIngredient
{

    public static function getIngredientForDisplay()
    {
        return modelIngredient::getIngredients();
    }

    public static function updateQuantiteIngredient($idIngredient, $quantiteIngredient)
    {
        return modelIngredient::updateQuantiteIngredient($idIngredient, $quantiteIngredient);
    }

    public static function updateSeuilAlerteIngredient($idIngredient, $seuilAlerte)
    {
        return modelIngredient::updateSeuilAlerteIngredient($idIngredient, $seuilAlerte);
    }
}

?>