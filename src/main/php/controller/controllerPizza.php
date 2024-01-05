<?php
include("../model/modelPizza.php");
class controllerPizza
{

    public static function getPizzasForDisplay()
    {
        return modelPizza::getPizzaProposee();
    }

    public static function getPrixPizza($id)
    {
        return modelPizza::calculPrix($id);
    }

    public static function getPizzaPanier($idPizzaPanier)
    {
        return modelPizza::getPizzaPanier($idPizzaPanier);

    }

    public static function getPizzaIngredient($idPizza)
    {
        $ingredients = modelPizza::getPizzaIngredient($idPizza);

        $capitalIngredients = array_map(function ($ingredient) {
            return ucwords($ingredient);
        }, $ingredients);

        return $capitalIngredients;
    }

    public static function ajoutPizzaDuMoment($idPizza)
    {
        modelPizza::ajoutPizzaDuMoment($idPizza);
    }

    public static function getPizzaDuMoment()
    {
        return modelPizza::getPizzaDuMoment();
    }

    public static function calculDistancePizzeria($pizzeriaAddress, $destination)
    {

    }
}



?>