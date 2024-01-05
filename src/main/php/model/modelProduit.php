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

}

?>