<?php
require_once("../model/modelCommande.php");

class controllerCommande
{
    public static function addCommandeAndGetId($dateCommande, $modePaiement, $idClient, $idAdresse)
    {
        return modelCommande::addCommandeAndGetId($dateCommande, $modePaiement, $idClient, $idAdresse);
    }
}
?>