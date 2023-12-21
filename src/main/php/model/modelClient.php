<?php

include("../config/connexion.php");

class modelClient
{

    public static function updateCompteClient($nom, $prenom, $email, $telephone, $password)
    {
        connexion::connect();
        $pdo = connexion::pdo();
        $existingAccountQuery = $pdo->prepare("SELECT idCompteClient FROM CompteClient WHERE adresseMail = :email");
        $existingAccountQuery->bindParam(':email', $email);
        $existingAccountQuery->execute();

        if ($existingAccountQuery->rowCount() > 0) {
            // L'adresse email est déjà utilisée'
            echo "<p class='erreur'>Un compte avec cette adresse email existe déjà. Veuillez utiliser une autre adresse email.</p>";
        } else {
            session_start();
            $idCompteClient = $_SESSION["idCompteClient"];
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE CompteClient SET CompteClient.adresseMail='$email', CompteClient.motDePasse='$passwordHash' WHERE CompteClient.idCompteClient = $idCompteClient";
            $pdo->exec($sql);
            $sql = "UPDATE Client SET Client.nomClient='$nom', Client.prenomClient='$prenom', Client.telephone='$telephone' WHERE Client.idCompteClient = $idCompteClient";
            $pdo->exec($sql);

            $_SESSION["nom"] = $nom;
            $_SESSION["prenom"] = $prenom;
            exit();
        }

    }

    public static function connexion($email, $mot_de_passe)
    {
        connexion::connect();
        $pdo = connexion::pdo();

        $requete = "SELECT CompteClient.idCompteClient,CompteClient.motDePasse, Client.nomClient, Client.prenomClient, CompteClient.motDePasse 
        FROM CompteClient
        JOIN Client ON CompteClient.idCompteClient = Client.idCompteClient
        WHERE CompteClient.adresseMail = '$email'";

        $resultat = $pdo->query($requete);
        return $resultat;

    }

    public static function deleteIdClient($idCompteClient)
    {
        connexion::connect();
        $pdo = connexion::pdo();

        $requete = "DELETE FROM Client WHERE idCompteClient = '$idCompteClient'";
        $resultat = $pdo->query($requete);
        return $resultat;
    }

    public static function deleteCompteClient($idCompteClient)
    {
        connexion::connect();
        $pdo = connexion::pdo();

        $requete = "DELETE FROM CompteClient WHERE idCompteClient = '$idCompteClient'";
        $resultat = $pdo->query($requete);
        return $resultat;
    }

    public static function creerCompteClient($nom, $prenom, $telephone, $nombreAleatoire, $Id, $password)
    {        
        connexion::connect();
        $pdo = connexion::pdo();
        //Vérifier si le compte n'existe pas déjà
        $existingAccountQuery = $pdo->prepare("SELECT idCompteClient FROM CompteClient WHERE adresseMail = :email");
        $existingAccountQuery->bindParam(':email', $email);
        $existingAccountQuery->execute();

        if ($existingAccountQuery->rowCount() > 0) {
            // Le compte existe déjà 
            return false;
        } else {
            $nombreAleatoire = rand(100000, 999999);
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO CompteClient (adresseMail, motDePasse) VALUES (:email, :password)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $passwordHash);
            $stmt->execute();

            // Récupérer l'idCompteClient 
            $sqlId = "SELECT MAX(idCompteClient) as Id FROM CompteClient";
            $stmtId = $pdo->prepare($sqlId);
            $stmtId->execute();
            $resultId = $stmtId->fetch(PDO::FETCH_ASSOC);
            $Id = $resultId['Id'];

            $sql = "INSERT INTO Client (nomClient, prenomClient, telephone, reduction, numeroIdentificationAuPaiementExterne, idCompteClient) VALUES (:nom, :prenom, :telephone, 0, :nombreAleatoire, :Id)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':prenom', $prenom);
            $stmt->bindParam(':telephone', $telephone);
            $stmt->bindParam(':nombreAleatoire', $nombreAleatoire);
            $stmt->bindParam(':Id', $Id);
            $stmt->execute();
            return true;
        }
    }

}
?>