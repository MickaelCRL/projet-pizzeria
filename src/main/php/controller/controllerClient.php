<?php
include("../model/modelClient.php");

class controllerClient
{
    public static function updateCompteClient($idCompteClient, $nom, $prenom, $email, $telephone, $password)
    {
        $resultat = modelClient::update($idCompteClient, $nom, $prenom, $email, $telephone, $password);
        return $resultat;
    }



    public static function connexionCompteClient($email, $password)
    {
        $resultat = modelClient::getPasswordHash($email);
        if(!$resultat){
            return $resultat;
        }
        $passwordRow = $resultat->fetch(PDO::FETCH_ASSOC);
        if ($passwordRow) {
            $passwordHash = $passwordRow['motDePasse'];
        } else {
            return $resultat;
        }

        if (password_verify($_POST["mot_de_passe"], $passwordHash)) {            
            $resultat = modelClient::connexion($email, $passwordHash);
            return $resultat;
        }
    }

    public static function deleteCompteClient($idCompteClient)
    {
        $resultat = modelClient::deleteIdClient($idCompteClient);
        if ($resultat) {
            $resultat = modelClient::deleteCompteClient($idCompteClient);
            return $resultat;

        }
    }

    public static function newCompteClient($nom, $prenom, $email, $telephone, $nombreAleatoire, $Id, $password)
    {
        $resultat = modelClient::creerCompteClient($nom, $prenom, $email, $telephone, $nombreAleatoire, $Id, $password);
        return $resultat;
    }
}


?>