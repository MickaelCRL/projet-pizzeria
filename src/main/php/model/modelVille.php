<?php

require_once("../config/connexion.php");

class modelVille
{

    public static function getIdVille($nomVille, $codePostal)
    {
        connexion::connect();
        $pdo = connexion::pdo();
        $stmt = $pdo->prepare("SELECT idVille FROM Ville WHERE nomVille = :ville AND codePostal = :codePostal");
        $stmt->bindParam(':ville', $nomVille, PDO::PARAM_STR);
        $stmt->bindParam(':codePostal', $codePostal, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function addVille($nomVille, $codePostal)
    {
        connexion::connect();
        $pdo = connexion::pdo();
        $requete = "INSERT INTO Ville (nomVille, codePostal) VALUES (:nomVille, :codePostal)";
        $stmt = $pdo->prepare($requete);
        $stmt->bindParam(':nomVille', $nomVille, PDO::PARAM_STR);
        $stmt->bindParam(':codePostal', $codePostal, PDO::PARAM_STR);
        $stmt->execute();
    }
}

?>