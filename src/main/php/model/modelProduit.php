<?php
require_once("../config/connexion.php");
class modelProduit
{
    public static function getProduit()
    {
        $requete = "SELECT * FROM Produit";
        connexion::connect();
        $resultat = connexion::pdo()->query($requete);
        return $resultat;
    }

    public static function getProduitPanier($idProduitPanier)
    {
        $requete = "SELECT * FROM Produit WHERE idProduit= :id";
        connexion::connect();
        $statement = connexion::pdo()->prepare($requete);
        $statement->bindParam(':id', $idProduitPanier);
        $statement->execute();
        return $statement;
    }

    public static function getPrix($id)
    {
        $requete = "SELECT prixProduit FROM Produit";
        connexion::connect();
        $resultat = connexion::pdo()->query($requete);
        $row = $resultat->fetch(PDO::FETCH_ASSOC);
        $prix = htmlspecialchars($row['prixProduit']);
        return $prix;
    }

    public static function addProduit($nom, $quantite, $prix, $lienImage)
    {
        $requete = "INSERT INTO Produit (nomProduit, quantiteProduit, prixProduit, lienImage) VALUES (:nom, :quantite, :prix, :lienImage)";
        connexion::connect();
        $resultat = connexion::pdo()->prepare($requete);
        $resultat->bindParam(':nom', $nom);
        $resultat->bindParam(':quantite', $quantite);
        $resultat->bindParam(':prix', $prix);
        $resultat->bindParam(':lienImage', $lienImage);
        $resultat->execute();
        return $resultat;
    }

    public static function deleteProduit($id)
    {
        $requete = "DELETE FROM Inclut WHERE idProduit = :id";
        connexion::connect();
        $resultat = connexion::pdo()->prepare($requete);
        $resultat->bindParam(':id', $id);
        $resultat->execute();
        $requete = "DELETE FROM Produit WHERE idProduit = :id";
        connexion::connect();
        $resultat = connexion::pdo()->prepare($requete);
        $resultat->bindParam(':id', $id);
        $resultat->execute();
        return $resultat;
    }


}

?>