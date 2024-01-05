<?php
include("../model/modelGestionnaire.php");

class controllerGestionnaire
{
    public static function updateGestionnaire($idGestionnaire, $nom, $prenom, $email,$password)
    {
        $resultat = modelGestionnaire::update($idGestionnaire, $nom, $prenom, $email,$password);
        return $resultat;
    }



    public static function connexionGestionnaire($email, $password)
    {
        $resultat = modelGestionnaire::getPasswordHash($email);
        $passwordRow = $resultat->fetch(PDO::FETCH_ASSOC);
        if ($passwordRow) {
            $passwordHash = $passwordRow['motDePasse'];
        } else {
            return $resultat;
        }
        if (password_verify($_POST["mot_de_passe"], $passwordHash)) {
            $resultat = modelGestionnaire::connexion($email, $passwordHash);
            return $resultat;
        }
    }

    public static function deleteGestionnaire($idGestionnaire)
    {
        $resultat = modelGestionnaire::deleteGestionnaire($idGestionnaire);
        return $resultat;       
    }

    public static function newCompteGestionnaire($nom, $prenom, $email, $password)
    {
        $resultat = modelGestionnaire::creerCompteGestionnaire($nom, $prenom, $email, $password);
        return $resultat;
    }
}


?>