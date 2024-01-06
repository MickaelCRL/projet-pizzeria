<?php
require_once("../model/modelAdresse.php");

class controllerAdresse
{
    public static function getIdAdresse($adresse)
    {
        return modelAdresse::getIdAdresse($adresse);
    }
    public static function addAdresse($rue, $idVille)
    {
        modelAdresse::addAdresse($rue, $idVille);
    }
}
?>