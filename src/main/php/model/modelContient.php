<?php

require_once("../config/connexion.php");

class modelContient
{
    public static function addContient($idCommande, $idPizza, $listeIngredient, $quantitePizzaCommande)
    {
        connexion::connect();
        $pdo = connexion::pdo();
        $requete = "INSERT INTO Contient (idCommande, idPizza, listeIngredient, quantitePizzaCommande) VALUES (:idCommande, :idPizza, :listeIngredient, :quantitePizzaCommande)";
        $stmt = $pdo->prepare($requete);
        $stmt->bindParam(':idCommande', $idCommande);
        $stmt->bindParam(':idPizza', $idPizza);
        $stmt->bindParam(':listeIngredient', $listeIngredient);
        $stmt->bindParam(':quantitePizzaCommande', $quantitePizzaCommande);
        $stmt->execute();
    }

}

?>