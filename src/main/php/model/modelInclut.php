<?php

require_once("../config/connexion.php");

class modelInclut
{
    public static function addInclut($idCommande, $idProduit, $quantiteInclut)
    {
        connexion::connect();
        $pdo = connexion::pdo();
        $requete = "INSERT INTO Inclut (idCommande, idProduit, quantiteInclut) VALUES (:idCommande, :idProduit, :quantiteInclut)";
        $stmt = $pdo->prepare($requete);
        $stmt->bindParam(':idCommande', $idCommande);
        $stmt->bindParam(':idProduit', $idProduit);
        $stmt->bindParam(':quantiteInclut', $quantiteInclut);
        $stmt->execute();
    }

}

?>