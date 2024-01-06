<?php
require_once("../model/modelVille.php");

class controllerVille
{
    public static function getIdVille($nomVille, $codePostal)
    {
        return modelVille::getIdVille($nomVille, $codePostal);
    }
    public static function addVille($nomVille, $codePostal)
    {
        modelVille::addVille($nomVille, $codePostal);
    }
}
?>