<?php

require_once("../config/connexion.php");

class modelCommande
{
    public static function addCommandeAndGetId($dateCommande, $modePaiement, $idClient, $idAdresse)
    {
        connexion::connect();
        $pdo = connexion::pdo();

        $requete = "INSERT INTO Commande (dateCommande, modePaiement, idClient, idAdresse, idTicket) VALUES (:dateCommande, :modePaiement, :idClient, :idAdresse, NULL)";
        $stmt = $pdo->prepare($requete);
        $stmt->bindParam(':dateCommande', $dateCommande, PDO::PARAM_STR);
        $stmt->bindParam(':modePaiement', $modePaiement, PDO::PARAM_STR);
        $stmt->bindParam(':idClient', $idClient, PDO::PARAM_INT);
        $stmt->bindParam(':idAdresse', $idAdresse, PDO::PARAM_INT);
        $stmt->execute();

        $idCommande = $pdo->lastInsertId();
        return $idCommande;
    }
}

?>