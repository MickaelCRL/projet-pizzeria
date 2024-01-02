import java.sql.*;

import java.util.ArrayList;
import java.util.Scanner;

/**
 * Classe contenant les méthodes permettant de se connecter à la base de données
 * et d'exécuter des requêtes.
 */
public class OutilsJDBC {
    /**
     * Méthode qui permet de se connecter à la base de données.
     * 
     * @param url URL de la base de données
     * @return La connexion à la base de données
     */
    public static Connection openConnection(String url) {
        Connection co = null;
        try {
            Class.forName("com.mysql.cj.jdbc.Driver");
            co = DriverManager.getConnection(url);
        } catch (ClassNotFoundException e) {
            System.out.println("il manque le driver oracle");
            System.exit(1);
        } catch (SQLException e) {
            System.out.println("impossible de se connecter à l'url : " + url);
            System.exit(1);
        }
        return co;
    }

    /**
     * Méthode qui permet d'exécuter une requête.
     * 
     * @param requete Requête à exécuter
     * @param co      Connexion à la base de données
     * @param type    Type de requête (0 : requête SELECT, 1 : requête SELECT avec scroll, 2 (ou autre) : requête UPDATE)
     * @return Le résultat de la requête
     */
    public static ResultSet exec1Requete(String requete, Connection co, int type) {
        ResultSet res = null;
        try {
            Statement st;
            if (type == 0) {
                st = co.createStatement();
                res = st.executeQuery(requete);
            } else if (type == 1) {
                st = co.createStatement(ResultSet.TYPE_SCROLL_INSENSITIVE,
                        ResultSet.CONCUR_READ_ONLY);
                res = st.executeQuery(requete);
            }
            else{
                st = co.createStatement(ResultSet.TYPE_SCROLL_SENSITIVE,
                        ResultSet.CONCUR_UPDATABLE);
                int nbUpdate = st.executeUpdate(requete);
                System.out.println("Nombre de lignes modifiées : " + nbUpdate);
            }
           
            
        } catch (SQLException e) {
            System.out.println("Problème lors de l'exécution de la requete : " + requete);
        }
        ;
        return res;
    }

    /**
     * Méthode qui permet de fermer la connexion à la base de données.
     * 
     * @param co Connexion à la base de données
     */
    public static void closeConnection(Connection co) {
        try {
            co.close();
            System.out.println("Connexion fermée!");
        } catch (SQLException e) {
            System.out.println("Impossible de fermer la connexion");
        }
    }

     /**
     * Fonction pour terminer la préparation d'une pizza.
     * Elle met à jour la base de données pour indiquer que la pizza a été préparée.
     * Pour cela, elle met à jour l'état de la pizza à true (ce qui signifie qu'elle a été préparée)
     * et la quantité à préparer à 0.
     * @param nomPizzaASupp nom de la pizza à supprimer de la base de données
     */
    public void terminerPizza(String nomPizzaASupp, Connection maConnection) {
        exec1Requete("UPDATE Pizza SET etatPizza=true WHERE nomPizza = '" + nomPizzaASupp + "'", maConnection, 2);
        exec1Requete("UPDATE Pizza SET quantitePizzaAPrepare=0 WHERE nomPizza = '" + nomPizzaASupp + "'",
                maConnection, 2);
    }
}

