<?php
require_once("../config/connexion.php");
class modelStatistiques
{
    public static function getStatistiquesJournalier()
    {
        $requete = "SELECT valeurStatistique FROM EnsembleStatistique WHERE typeStatistique = 'journalier' AND dateDebut = CURRENT_DATE()";
        connexion::connect();
        $resultat = connexion::pdo()->query($requete);
        return $resultat;
    }

    public static function createStatistiquesJournalier($valeurStatistique)
    {
        $requete = "INSERT INTO EnsembleStatistique (typeStatistique, valeurStatistique, idPizzeria,dateDebut,dateDeFin) VALUES ('journalier', $valeurStatistique, 1, CURRENT_DATE(), CURRENT_DATE())";
        connexion::connect();
        connexion::pdo()->exec($requete);
    }

    public static function getStatistiquesHebdomadaire()
    {
        // Obtention du jour de la semaine (1 pour lundi, 2 pour mardi, ..., 7 pour dimanche)
        $jourActuel = date("N");

        // Calcul de la différence de jours pour ajuster la date
        $diffJours = ($jourActuel == 1) ? 0 : ($jourActuel - 1);

        // Obtention de la date du lundi précédent ou de la date actuelle si c'est lundi
        $dateLundiPrecedent = date("Y-m-d", strtotime("-$diffJours days"));

        $requete = "SELECT valeurStatistique FROM EnsembleStatistique WHERE typeStatistique = 'hebdomadaire' AND dateDebut = '$dateLundiPrecedent'";
        connexion::connect();
        $resultat = connexion::pdo()->query($requete);
        return $resultat;
    }

    public static function createStatistiquesHebdomadaire($valeurStatistique)
    {
        // Obtention du jour de la semaine (1 pour lundi, 2 pour mardi, ..., 7 pour dimanche)
        $jourActuel = date("N");

        // Calcul de la différence de jours pour ajuster la date
        $diffJours = ($jourActuel == 1) ? 0 : ($jourActuel - 1);

        // Obtention de la date du lundi précédent ou de la date actuelle si c'est lundi
        $dateLundiPrecedent = date("Y-m-d", strtotime("-$diffJours days"));

        // Obtention du jour de la semaine actuel en ISO-8601 (1 pour lundi, 2 pour mardi, ..., 7 pour dimanche)
        $jourActuel = date("N");

        // Calcul de la différence de jours pour atteindre le dimanche suivant
        $diffJours = ($jourActuel == 7) ? 0 : (7 - $jourActuel);

        // Obtention de la date du dimanche suivant
        $dateDimancheSuivant = date("Y-m-d", strtotime("+$diffJours days"));

        $requete = "INSERT INTO EnsembleStatistique (typeStatistique, valeurStatistique, idPizzeria,dateDebut,dateDeFin) VALUES ('hebdomadaire', $valeurStatistique, 1, '$dateLundiPrecedent', '$dateDimancheSuivant')";
        connexion::connect();
        connexion::pdo()->exec($requete);
    }

    public static function getStatistiquesMensuel()
    {
        $moisActuel = date("m");
        $anneeActuelle = date("Y");
        $requete = "SELECT valeurStatistique FROM EnsembleStatistique WHERE typeStatistique = 'mensuel' AND dateDebut = '$anneeActuelle-$moisActuel-01'";
        connexion::connect();
        $resultat = connexion::pdo()->query($requete);
        return $resultat;
    }


    public static function createStatistiquesMensuel($valeurStatistique)
    {
        $moisActuel = date("m");
        $anneeActuelle = date("Y");
    
        // Obtention de la date du premier jour du mois actuel
        $dateDebut = "$anneeActuelle-$moisActuel-01";
    
        // Calcul de la date du dernier jour du mois actuel
        $dateFin = date("Y-m-d", strtotime("$dateDebut +1 month -1 day"));
    
        $requete = "INSERT INTO EnsembleStatistique (typeStatistique, valeurStatistique, idPizzeria, dateDebut, dateDeFin) VALUES ('mensuel', $valeurStatistique, 1, '$dateDebut', '$dateFin')";
        
        connexion::connect();
        connexion::pdo()->exec($requete);
    }
    

    public static function updateStatistiques($prixCommande){
        //Vérifier si les statistiques journalières existent
        $requete = "SELECT * FROM EnsembleStatistique WHERE typeStatistique = 'journalier' AND dateDebut = CURRENT_DATE()";
        connexion::connect();
        $resultat = connexion::pdo()->query($requete);
        if ($resultat->rowCount() == 0) {
            // Si les statistiques journalières n'existent pas, il faut les créer
            modelStatistiques::createStatistiquesJournalier($prixCommande);
        }
        // Update les statistiques journalières
        $requete = "UPDATE EnsembleStatistique SET valeurStatistique = valeurStatistique + $prixCommande WHERE typeStatistique = 'journalier' AND dateDebut = CURRENT_DATE()";
        connexion::connect();
        connexion::pdo()->exec($requete);
        // Update les statistiques hebdomadaires
        // Obtention du jour de la semaine (1 pour lundi, 2 pour mardi, ..., 7 pour dimanche)
        $jourActuel = date("N");
        $anneeActuelle = date("Y");
        $moisActuel = date("m");
        // Calcul de la différence de jours pour ajuster la date
        $diffJours = ($jourActuel == 1) ? 0 : ($jourActuel - 1);
        // Obtention de la date du lundi précédent ou de la date actuelle si c'est lundi
        $dateLundiPrecedent = date("Y-m-d", strtotime("-$diffJours days"));
        // Vérifier si les statistiques hebdomadaires existent
        $requete = "SELECT * FROM EnsembleStatistique WHERE typeStatistique = 'hebdomadaire' AND dateDebut = '$dateLundiPrecedent'";
        connexion::connect();
        $resultat = connexion::pdo()->query($requete);
        if ($resultat->rowCount() == 0) {
            // Si les statistiques hebdomadaires n'existent pas, il faut les créer
            modelStatistiques::createStatistiquesHebdomadaire($prixCommande);
        }
        $requete = "UPDATE EnsembleStatistique SET valeurStatistique = valeurStatistique + $prixCommande WHERE typeStatistique = 'hebdomadaire' AND dateDebut = '$dateLundiPrecedent'";
        connexion::connect();
        connexion::pdo()->exec($requete);
        // Vérifier si les statistiques mensuelles existent
        $requete = "SELECT * FROM EnsembleStatistique WHERE typeStatistique = 'mensuel' AND dateDebut = '$anneeActuelle-$moisActuel-01'";
        connexion::connect();
        $resultat = connexion::pdo()->query($requete);
        if ($resultat->rowCount() == 0) {
            // Si les statistiques mensuelles n'existent pas, il faut les créer
            modelStatistiques::createStatistiquesMensuel($prixCommande);
        }
        // Update les statistiques mensuelles
        $requete = "UPDATE EnsembleStatistique SET valeurStatistique = valeurStatistique + $prixCommande WHERE typeStatistique = 'mensuel' AND dateDebut = '$anneeActuelle-$moisActuel-01'";
        connexion::connect();
        connexion::pdo()->exec($requete);

    }



}

?>