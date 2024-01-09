import java.sql.*;

import java.util.ArrayList;
import java.util.Scanner;

public class OutilsJDBC {

    //static String url = "jdbc:oracle:thin:mmassin/20040728@oracle.iut-orsay.fr:1521:etudom";
    static String url="jdbc:mysql://192.70.36.54/saes3pizzeria?user=saes3pizzeria&password=]bBWo[QUw65[]0FG&zeroDateTimeBehavior=convertToNull";


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
    public static void terminerPizza(String idPizzaASupp, Connection maConnection) {
        exec1Requete("UPDATE Pizza SET etatPizza=true WHERE idPizza = " + idPizzaASupp, maConnection, 2);
        exec1Requete("UPDATE Pizza SET quantitePizzaAPrepare=0 WHERE idPizza = " + idPizzaASupp,
                maConnection, 2);
    }
    
    public static void updateQuantitePizza(int idPizza, int newQuantite, Connection maConnection) {
    	exec1Requete("UPDATE Pizza SET quantitePizzaAPrepare="+newQuantite+" WHERE idPizza = "+idPizza,maConnection,2);
    }
   
}

