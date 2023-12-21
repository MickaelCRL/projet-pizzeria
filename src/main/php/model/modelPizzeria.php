<?php
include("../config/connexion.php");
class ModelPizzeria
{
    private $idPizzeria = 1;
    public static function getAdresse()
    {      
        connexion::connect();
        $pdo = connexion::pdo();
        $query = "SELECT a.rue, v.nomVille, v.codePostal 
        FROM Pizzeria AS p 
        JOIN Adresse AS a ON p.idAdresse = a.idAdresse 
        JOIN Ville AS v ON a.idVille = v.idVille 
        WHERE p.idPizzeria = :idPizzeria";
        $statement = $pdo->prepare($query);
        $statement->bindParam(':idPizzeria', $idPizzeria, PDO::PARAM_INT);
        $statement->execute();
        $pizzeriaAddress = $statement->fetch(PDO::FETCH_ASSOC);
        if ($pizzeriaAddress) {
            // Crée une chaîne avec les détails de l'adresse
            $addressStringPizzeria = $pizzeriaAddress['rue'] . ', ' . $pizzeriaAddress['nomVille'] . ', ' . $pizzeriaAddress['codePostal'] . ", France";
            return $addressStringPizzeria;
        }

    }
}


?>