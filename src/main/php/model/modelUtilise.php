<?php

require_once("../config/connexion.php");

class modelUtilise
{

    public static function addUtilise($idPizza, $idIngredient)
    {
        $requete = "INSERT INTO Utilise (idPizza, idIngredient) VALUES (:idPizza, :idIngredient)";
        connexion::connect();
        $resultat = connexion::pdo()->prepare($requete);
        $resultat->bindParam(':idPizza', $idPizza);
        $resultat->bindParam(':idIngredient', $idIngredient);
        $resultat->execute();
        return $resultat;
    }
}

?>