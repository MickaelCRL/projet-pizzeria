<?php
require_once("../config/connexion.php");
class modelIngredient
{
    public static function getIngredients()
    {
        $requete = "SELECT * FROM Ingredient";
        connexion::connect();
        $resultat = connexion::pdo()->query($requete);
        return $resultat;
    }

    public static function updateQuantiteIngredient($idIngredient, $quantiteIngredient)
    {
        $requete = "UPDATE Ingredient SET quantiteIngredient = :quantiteIngredient WHERE idIngredient = :idIngredient";
        connexion::connect();
        $resultat = connexion::pdo()->prepare($requete);
        $resultat->bindParam(':idIngredient', $idIngredient);
        $resultat->bindParam(':quantiteIngredient', $quantiteIngredient);
        $resultat->execute();
        return $resultat;
    }

    public static function updateSeuilAlerteIngredient($idIngredient, $seuilAlerte)
    {
        $requete = "UPDATE Ingredient SET seuilAlerte = :seuilAlerteIngredient WHERE idIngredient = :idIngredient";
        connexion::connect();
        $resultat = connexion::pdo()->prepare($requete);
        $resultat->bindParam(':idIngredient', $idIngredient);
        $resultat->bindParam(':seuilAlerteIngredient', $seuilAlerte);
        $resultat->execute();
        return $resultat;
    }
}

?>