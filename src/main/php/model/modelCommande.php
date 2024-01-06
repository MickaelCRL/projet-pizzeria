<?php

require_once("../config/connexion.php");

class modelCommande
{
    public static function addCommande()
    {
        connexion::connect();
        $pdo = connexion::pdo();
    }
}

?>