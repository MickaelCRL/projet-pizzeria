<?php
include("../model/modelIngredient.php");
class controllerIngredient
{

    public static function getIngredientForDisplay()
    {
        return modelIngredient::getIngredients();
    }

    public static function getAutreIngredient($tabIngredient)
    {
        return modelIngredient::getAutreIngredient($tabIngredient);
    }


    public static function updateQuantiteIngredient($idIngredient, $quantiteIngredient)
    {
        return modelIngredient::updateQuantiteIngredient($idIngredient, $quantiteIngredient);
    }

    public static function updateSeuilAlerteIngredient($idIngredient, $seuilAlerte)
    {
        return modelIngredient::updateSeuilAlerteIngredient($idIngredient, $seuilAlerte);
    }

    public static function nouvelIngredientPizza($idIngredient,$idPizza){
        return modelIngredient::nouvelIngredientPizza($idIngredient,$idPizza);
    }
}

?>