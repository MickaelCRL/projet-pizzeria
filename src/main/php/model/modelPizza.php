<?php
require_once("../config/connexion.php");
class modelPizza
{
    public static function getPizzaProposee()
    {
        $requete = "SELECT * FROM VuePizzaProposee";
        connexion::connect();
        $resultat = connexion::pdo()->query($requete);
        return $resultat;
    }

    public static function calculPrix($id)
    {
        $requete = "SELECT calculerPrixPizza($id) AS prix";
        connexion::connect();
        $resultat = connexion::pdo()->query($requete);
        $row = $resultat->fetch(PDO::FETCH_ASSOC);
        $prix = htmlspecialchars($row['prix']);
        return $prix;
    }

    public static function getPizzaPanier($idPizzaPanier)
    {
        $requete = "SELECT * FROM VuePizzaProposee WHERE idPizza = :id";
        connexion::connect();
        $statement = connexion::pdo()->prepare($requete);
        $statement->bindParam(':id', $idPizzaPanier);
        $statement->execute();
        return $statement;
    }

    public static function getPizzaIngredient($idPizza)
    {
        connexion::connect();
        $stmt = connexion::pdo()->prepare("SELECT recette FROM Pizza WHERE idPizza = :idPizza");
        $stmt->bindParam(':idPizza', $idPizza);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $recette = $result['recette'];

            // Utilisation de la fonction explode pour séparer les ingrédients
            $ingredients = explode(", ", $recette);
            return $ingredients;
        } else {
            return []; // Retourne un tableau vide si la pizza n'a pas de recette
        }

    }

    public static function ajoutPizzaDuMoment($idPizza)
    {
        connexion::connect();
        $requete = "UPDATE Pizza SET pizzaDuMoment = false WHERE pizzaDuMoment = true";
        connexion::pdo()->exec($requete);
        $requete = "UPDATE Pizza SET pizzaDuMoment = true WHERE idPizza = $idPizza";
        connexion::pdo()->exec($requete);
    }

    public static function getPizzaDuMoment()
    {
        $requete = "SELECT * FROM VuePizzaProposee WHERE pizzaDuMoment = true";
        connexion::connect();
        $resultat = connexion::pdo()->query($requete);
        return $resultat;
    }

}

?>