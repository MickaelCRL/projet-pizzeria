<?php 
    require_once("config/connexion.php");
    connexion::connect();
    $pdo = connexion::pdo();
    session_start();
    $idCompteClient = $_SESSION["idCompteClient"];
    $requete = "DELETE FROM Client WHERE idCompteClient = '$idCompteClient'";
    $resultat = $pdo->query($requete);
    if($resultat){
        $requete = "DELETE FROM CompteClient WHERE idCompteClient = '$idCompteClient'";
        $resultat = $pdo->query($requete);
        if($resultat){ session_destroy();
            header('Location: indexPizza.php');
            exit();}
        else{
            echo "<p class='erreur'> Échec de la requête SQL. </p>";
        }      
    }
    else{
        echo "<p class='erreur'> Échec de la requête SQL. </p>";
    }
?>