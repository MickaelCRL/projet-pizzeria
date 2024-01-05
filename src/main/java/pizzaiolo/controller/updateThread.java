import java.sql.Connection;

/*
 * Classe qui permet de créer un thread qui s'exécute toutes les 10 secondes.
 * Elle permet de mettre à jour les données du tableau en prenant celle de la base de données.
 */
public class updateThread extends Thread {

    private FenetrePizzaiolo f;
    private Connection co;
    private OutilsJDBC outilsJDBC;
    private String[][] data;

    /**
     * Constructeur de la classe updateThread.
     * 
     * @param testButton  Fenêtre du pizzaiolo
     * @param co          Connexion à la base de données
     * @param outilsJDBC  Outils pour la base de données
     */
    public updateThread(FenetrePizzaiolo f, Connection co, OutilsJDBC outilsJDBC, String[][] data) {
        super();
        this.f = f;
        this.co = co;
        this.outilsJDBC = outilsJDBC;
        this.data = data;
    }

    /**
     * Méthode qui permet de lancer le thread.
     * Elle appelle la méthode updateDataFromDataBase de la classe FenetrePizzaiolo
     * pour mettre à jour les données du tableau.
     */
    public void run() {
        while (true) {
            f.updateDataFromDataBase(co, outilsJDBC,data);
            System.out.println("update");
            try {
                Thread.sleep(10000); // Pause le thread pendant 10 secondes
            } catch (InterruptedException e) {
                e.printStackTrace();
            }
        }
    }
}