import java.sql.Connection;

/*
 * Classe qui permet de créer un thread qui s'exécute toutes les 10 secondes.
 * Elle permet de mettre à jour les données du tableau en prenant celle de la base de données.
 */
public class updateThread extends Thread {

    private FenetrePizzaiolo testButton;
    private Connection co;
    private OutilsJDBC outilsJDBC;

    
    /**
     * Constructeur de la classe updateThread.
     * 
     * @param testButton  Fenêtre du pizzaiolo
     * @param co          Connexion à la base de données
     * @param outilsJDBC  Outils pour la base de données
     */
    public updateThread(FenetrePizzaiolo testButton, Connection co, OutilsJDBC outilsJDBC) {
        super();
        this.testButton = testButton;
        this.co = co;
        this.outilsJDBC = outilsJDBC;
    }

     /**
     * Méthode qui permet de lancer le thread.
     * Elle appelle la méthode updateDataFromDataBase de la classe FenetrePizzaiolo
     * pour mettre à jour les données du tableau.
     */
    public void run() {
        while (true) {
            System.out.println("Le thread est là");
            testButton.updateDataFromDataBase(co, outilsJDBC);
            try {
                Thread.sleep(10000); // Pause le thread pendant 10 secondes
            } catch (InterruptedException e) {
                e.printStackTrace();
            }
        }
    }
    
}