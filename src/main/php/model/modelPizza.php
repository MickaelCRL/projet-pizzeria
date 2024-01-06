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

    public static function getAllergenePizza($idPizza)
    {
        $requete = "SELECT * FROM Allergene NATURAL JOIN Renferme WHERE idPizza = :idPizza";
        connexion::connect();
        $statement = connexion::pdo()->prepare($requete);
        $statement->bindParam(':idPizza', $idPizza);
        $statement->execute();
        return $statement;
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
    public static function addPizza($nomPizza, $pizzaDuMoment, $recette, $quantitePizzaAPrepare, $etatPizza, $lienImage)
    {
        connexion::connect();
        $requete = "INSERT INTO Pizza (nomPizza, lienImage) VALUES (:nomPizza, :pizzaDuMoment, :recette, :quantitePizzaAPrepare, :etatPizza, :lienImage)";
        $stmt = connexion::pdo()->prepare($requete);
        $stmt->bindParam(':nomPizza', $nomPizza, PDO::PARAM_STR);
        $stmt->bindParam(':pizzaDuMoment', $pizzaDuMoment, PDO::PARAM_STR);
        $stmt->bindParam(':recette', $recette, PDO::PARAM_STR);
        $stmt->bindParam(':quantitePizzaAPrepare', $quantitePizzaAPrepare, PDO::PARAM_STR);
        $stmt->bindParam(':etatPizza', $etatPizza, PDO::PARAM_STR);
        $stmt->bindParam(':lienImage', $lienImage, PDO::PARAM_STR);
        $stmt->execute();

    }

    public static function nouvellePizza($nomPizza, $lienImage)
    {
        $requete = "INSERT INTO Pizza (nomPizza, pizzaDuMoment, quantitePizzaAPrepare,etatPizza, lienImage, idPizzaiolo) VALUES (:nomPizza, false, 0, true, :lienImage, null)";
        connexion::connect();
        $resultat = connexion::pdo()->prepare($requete);
        $resultat->bindParam(':nomPizza', $nomPizza);
        $resultat->bindParam(':lienImage', $lienImage);
        $resultat->execute();
        $requete = "SELECT MAX(idPizza) FROM Pizza";
        $resultat = connexion::pdo()->prepare($requete);
        $resultat->execute();
        $row = $resultat->fetch(PDO::FETCH_ASSOC);
        $idPizza = htmlspecialchars($row['MAX(idPizza)']);
        $requete = "INSERT INTO Propose (idPizza, idPizzeria) VALUES ($idPizza, 1)";
        $resultat = connexion::pdo()->prepare($requete);
        $resultat->execute();
        return $idPizza;
    }

    public static function updateRecettePizza($idPizza)
    {
        $requete = "CALL updateRecette($idPizza)";
        connexion::connect();
        $resultat = connexion::pdo()->prepare($requete);
        $resultat->execute();
        return $resultat;
    }

    public static function nouvelAllergenePizza($idPizza, $nomAllergene)
    {
        $requete = "INSERT INTO Allergene (nomAllergene, descriptionAllergene) VALUES (:nomAllergene, null)";
        connexion::connect();
        $resultat = connexion::pdo()->prepare($requete);
        $resultat->bindParam(':nomAllergene', $nomAllergene, PDO::PARAM_STR);
        $resultat->execute();
        $requete = "SELECT MAX(idAllergene) FROM Allergene";
        $resultat = connexion::pdo()->prepare($requete);
        $resultat->execute();
        $row = $resultat->fetch(PDO::FETCH_ASSOC);
        $idAllergene = htmlspecialchars($row['MAX(idAllergene)']);
        $requete = "INSERT INTO Renferme (idPizza, idAllergene) VALUES ($idPizza, $idAllergene)";
        $resultat = connexion::pdo()->prepare($requete);
        $resultat->execute();
        return $resultat;
    }

    public static function supprimerPizza($idPizza)
    {
        $requete = "DELETE FROM Contient WHERE idPizza = :idPizza";
        connexion::connect();
        $resultat = connexion::pdo()->prepare($requete);
        $resultat->bindParam(':idPizza', $idPizza);
        $resultat->execute();
        $requete = "DELETE FROM Renferme WHERE idPizza = :idPizza";
        $resultat = connexion::pdo()->prepare($requete);
        $resultat->bindParam(':idPizza', $idPizza);
        $resultat->execute();
        $requete = "DELETE FROM Utilise WHERE idPizza = :idPizza";
        $resultat = connexion::pdo()->prepare($requete);
        $resultat->bindParam(':idPizza', $idPizza);
        $resultat->execute();
        $requete = "DELETE FROM Propose WHERE idPizza = :idPizza";
        $resultat = connexion::pdo()->prepare($requete);
        $resultat->bindParam(':idPizza', $idPizza);
        $resultat->execute();
        $requete = "DELETE FROM Pizza WHERE idPizza = :idPizza";
        $resultat = connexion::pdo()->prepare($requete);
        $resultat->bindParam(':idPizza', $idPizza);
        $resultat->execute();
        return $resultat;
    }

}

?>