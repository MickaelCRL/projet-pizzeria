<?php
require_once("../config/connexion.php");
class modelStatistiques
{
    public static function getStatistiquesJournalier()
    {
        $requete = "SELECT valeurStatistique FROM EnsembleStatistique WHERE typeStatistique = 'journalier'";
        connexion::connect();
        $resultat = connexion::pdo()->query($requete);
        return $resultat;
    }

    public static function getStatistiquesHebdomadaire()
    {
        $requete = "SELECT valeurStatistique FROM EnsembleStatistique WHERE typeStatistique = 'hebdomadaire'";
        connexion::connect();
        $resultat = connexion::pdo()->query($requete);
        return $resultat;
    }

    public static function getStatistiquesMensuel()
    {
        $requete = "SELECT valeurStatistique FROM EnsembleStatistique WHERE typeStatistique = 'mensuel'";
        connexion::connect();
        $resultat = connexion::pdo()->query($requete);
        return $resultat;
    }






}

?>