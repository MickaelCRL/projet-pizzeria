<?php

require_once("../config/connexion.php");

class modelAdresse
{


    public static function getIdAdresse($adresse)
    {
        connexion::connect();
        $pdo = connexion::pdo();

        $stmt = $pdo->prepare("SELECT idAdresse FROM Adresse WHERE rue = :adresse");
        $stmt->bindParam(':adresse', $adresse, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }


    public static function addAdresse($rue, $idVille)
    {
        connexion::connect();
        $pdo = connexion::pdo();

        $requete = "INSERT INTO Adresse (rue, idVille) VALUES (:rue, :idVille)";
        $stmt = $pdo->prepare($requete);
        $stmt->bindParam(':rue', $rue, PDO::PARAM_STR);
        $stmt->bindParam(':idVille', $idVille, PDO::PARAM_INT);
        $stmt->execute();
    }
}

?>