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


    public static void main(String[] args) {

        Connection maConnection = openConnection(url);

        ResultSet monResultat = exec1Requete("SELECT * FROM Pizza", maConnection, 0);


        //question 1

        System.out.println("------------------");
        System.out.println("QUESTION 1");
        System.out.println("------------------");

        try {
            while (monResultat.next()) {
                String nomPizza = monResultat.getString(2);
                System.out.println( " | " + nomPizza + " | ");

            }
        } catch (SQLException e) {
            System.out.println("Impossible d'afficher le ResultSet");
        }

        closeConnection(maConnection);
    }
}

