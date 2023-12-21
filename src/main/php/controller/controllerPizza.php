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
    
    public static function calculDistancePizzeria($pizzeriaAddress, $destination){
        
    }
}



?>