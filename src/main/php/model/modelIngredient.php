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

    public static function getAutreIngredient($tabIngredient)
    {
        connexion::connect();
        $placeholders = rtrim(str_repeat('?,', count($tabIngredient)), ',');
        $sql = "SELECT nomIngredient FROM Ingredient WHERE nomIngredient NOT IN ($placeholders)";

        $stmt = connexion::pdo()->prepare($sql);
        $stmt->execute($tabIngredient);

        $autreIngredients = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $autreIngredients[] = $row['nomIngredient'];
        }

        return $autreIngredients;

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

    public static function nouvelIngredientPizza($idPizza, $idIngredient){
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