<?php
include("../model/modelProduit.php");
class controllerProduit
{

    public static function getAllProduit()
    {
        return modelProduit::getProduit();
    }

    public static function getPrixProduit($id)
    {
        return modelProduit::getPrix($id);
    }

    public static function getProduitPanier($idProduitPanier)
    {
        return modelProduit::getProduitPanier($idProduitPanier);

    }
}
?>