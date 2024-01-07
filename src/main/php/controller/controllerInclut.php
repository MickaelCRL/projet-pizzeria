<?php
require_once("../model/modelInclut.php");

class controllerInclut
{
    public static function addInclut($idCommande, $idProduit, $quantiteInclut)
    {
        modelInclut::addInclut($idCommande, $idProduit, $quantiteInclut);
    }
}
?>