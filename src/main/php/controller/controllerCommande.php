<?php
require_once("../model/modelCommande.php");

class controllerCommande
{
    public static function addCommande($dateCommande, $modePaiement, $idClient, $idAdresse)
    {
        modelCommande::addCommande($dateCommande, $modePaiement, $idClient, $idAdresse);
    }
}
?>