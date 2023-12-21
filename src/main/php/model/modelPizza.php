<?php
include("../config/connexion.php");
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
        return $prix ;
    }

    public static function getPizzaPanier($idPizzaPanier)
    {        
        $requete = "SELECT * FROM VuePizzaProposee WHERE idPizza = $idPizzaPanier";
        connexion::connect();
        $resultat = connexion::pdo()->query($requete);
        return $resultat;
    }

}

?>