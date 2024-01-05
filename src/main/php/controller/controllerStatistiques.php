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
                    return null;
                } else {
                    $stat = $resultat->fetch(PDO::FETCH_ASSOC);
                    return $stat['valeurStatistique'];
                }
            case 'hebdomadaire':
                $resultat = modelStatistiques::getStatistiquesHebdomadaire();
                if($resultat->rowCount() == 0){
                    return null;
                } else {
                    $stat = $resultat->fetch(PDO::FETCH_ASSOC);
                    return $stat['valeurStatistique'];
                }
            case 'mensuel':
                $resultat = modelStatistiques::getStatistiquesMensuel();
                if($resultat->rowCount() == 0){
                    return null;
                } else {
                    $stat = $resultat->fetch(PDO::FETCH_ASSOC);
                    return $stat['valeurStatistique'];
                }
            default:
                return null;
        }
    }

}

?>