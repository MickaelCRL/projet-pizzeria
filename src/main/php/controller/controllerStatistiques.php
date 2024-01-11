<?php
include("../model/modelStatistiques.php");
class controllerStatistiques
{

    public static function getStatistiquesForDisplay($typeStats)
    {
        switch ($typeStats) {
            case 'journalier':
                $resultat = modelStatistiques::getStatistiquesJournalier();
                if($resultat->rowCount() == 0){
                    modelStatistiques::createStatistiquesJournalier(0);
                    $resultat = modelStatistiques::getStatistiquesJournalier();
                    $stat = $resultat->fetch(PDO::FETCH_ASSOC);
                    return $stat['valeurStatistique'];
                } else {
                    $stat = $resultat->fetch(PDO::FETCH_ASSOC);
                    return $stat['valeurStatistique'];
                }
            case 'hebdomadaire':
                $resultat = modelStatistiques::getStatistiquesHebdomadaire();
                if($resultat->rowCount() == 0){
                    modelStatistiques::createStatistiquesHebdomadaire(0);
                    $resultat = modelStatistiques::getStatistiquesHebdomadaire();
                    $stat = $resultat->fetch(PDO::FETCH_ASSOC);
                    return $stat['valeurStatistique'];
                } else {
                    $stat = $resultat->fetch(PDO::FETCH_ASSOC);
                    return $stat['valeurStatistique'];
                }
            case 'mensuel':
                $resultat = modelStatistiques::getStatistiquesMensuel();
                if($resultat->rowCount() == 0){
                    modelStatistiques::createStatistiquesMensuel(0);
                    $resultat = modelStatistiques::getStatistiquesMensuel();
                    $stat = $resultat->fetch(PDO::FETCH_ASSOC);
                    return $stat['valeurStatistique'];
                } else {
                    $stat = $resultat->fetch(PDO::FETCH_ASSOC);
                    return $stat['valeurStatistique'];
                }
            default:
                return null;
        }
    }

    public static function updateStatistiques($prixCommande){
        modelStatistiques::updateStatistiques($prixCommande);
    }

}

?>