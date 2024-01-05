<?php

include_once("../config/connexion.php");

class modelGestionnaire
{

    public static function update($idGestionnaire, $nom, $prenom, $email, $password)
    {
        connexion::connect();
        $pdo = connexion::pdo();
        $existingAccountQuery = $pdo->prepare("SELECT idGestionnaire FROM Gestionnaire WHERE adresseMail = :email AND idGestionnaire != :idGestionnaire");
        $existingAccountQuery->bindParam(':email', $email);
        $existingAccountQuery->bindParam(':idGestionnaire', $idGestionnaire);
        $existingAccountQuery->execute();

        if ($existingAccountQuery->rowCount() > 0) {
            return false;
        } else {               
            $sql = "UPDATE Gestionnaire SET Gestionnaire.nomGestionnaire='$nom', Gestionnaire.prenomGestionnaire='$prenom', Gestionnaire.adresseMail='$email', Gestionnaire.motDePasse='$password' WHERE Gestionnaire.idGestionnaire = $idGestionnaire";
            $pdo->exec($sql);         
            return true;
        }

    }

    public static function getPasswordHash($email)
    {
        connexion::connect();
        $pdo = connexion::pdo();

        $requete = "SELECT Gestionnaire.motDePasse
        FROM Gestionnaire
        WHERE Gestionnaire.adresseMail = '$email'";
        $resultat = $pdo->query($requete);
        return $resultat;

    }

    public static function connexion($email, $password)
    {
        connexion::connect();
        $pdo = connexion::pdo();

        $requete = "SELECT Gestionnaire.idGestionnaire, Gestionnaire.motDePasse, Gestionnaire.nomGestionnaire, Gestionnaire.prenomGestionnaire
        FROM Gestionnaire
        WHERE Gestionnaire.adresseMail = '$email' AND Gestionnaire.motDePasse = '$password'";

        $resultat = $pdo->query($requete);
        return $resultat;

    }

    public static function deleteGestionnaire($idGestionnaire)
    {
        connexion::connect();
        $pdo = connexion::pdo();

        $requete = "DELETE FROM Gestionnaire WHERE idGestionnaire = '$idGestionnaire'";
        $resultat = $pdo->query($requete);
        return $resultat;
    }

    public static function creerCompteGestionnaire($nom, $prenom, $email,$password)
    {        
        connexion::connect();
        $pdo = connexion::pdo();
        //Vérifier si le compte n'existe pas déjà
        $existingAccountQuery = $pdo->prepare("SELECT idGestionnaire FROM Gestionnaire WHERE adresseMail = :email");
        $existingAccountQuery->bindParam(':email', $email);
        $existingAccountQuery->execute();

        if ($existingAccountQuery->rowCount() > 0) {
            // Le compte existe déjà 
            return false;
        } else {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO Gestionnaire (nomGestionnaire, prenomGestionnaire, adresseMail, motDePasse) VALUES (:nom, :prenom, :email, :password)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':prenom', $prenom);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $passwordHash);
            $stmt->execute();
            return true;
        }
    }

}
?>