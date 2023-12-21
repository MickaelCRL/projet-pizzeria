<?php
include("../model/modelClient.php");

class controllerClient
{
    public static function verifPassword()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Retrieve form data
            $nom = $_POST["nom"];
            $prenom = $_POST["prenom"];
            $email = $_POST["email"];
            $telephone = $_POST["telephone"];
            $password = $_POST["password"];
            $confirm_password = $_POST["confirm_password"];

            // Validate password and confirmation
            if ($password != $confirm_password) {
                echo "<p class='erreur'> Votre mot de passe et sa confirmation ne correspondent pas. Essayez à nouveau !</p>";
            } else {
                modelClient::updateCompteClient($nom, $prenom, $email, $telephone, $password);
                header('Location: vueEspaceCompte.php');
            }

        }
    }
    public static function connexionCompteClient($email, $mot_de_passe)
    {
        $resultat = modelClient::connexion($email, $mot_de_passe);
        return $resultat;
    }

    public static function deleteCompteClient($idCompteClient)
    {
        $resultat = modelClient::deleteIdClient($idCompteClient);
        if ($resultat) {
            $resultat = modelClient::deleteCompteClient($idCompteClient);
            return $resultat;

        }
    }

    public static function newCompteClient($nom, $prenom, $telephone, $nombreAleatoire, $Id, $password ){
        $resultat = modelClient::creerCompteClient($nom, $prenom, $telephone, $nombreAleatoire, $Id, $password);
        return $resultat;       
    }
}


?>