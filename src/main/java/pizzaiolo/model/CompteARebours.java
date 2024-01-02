import java.util.Timer;
import java.util.TimerTask;

/**
 * Classe du compte à rebours de 15 minutes pour les pizzas.
 * Il est définit à 15 minutes puisque le client doit reçevoir sa commande
 * dans un délai de 45 minutes maximum (sinon il reçevra une réduction) et
 * que la livraison ne doit pas prendre plus de 30min.
 */
public class CompteARebours {

    private int tempsRestant = 15 * 60; // 15 minutes en secondes

    public static void main(String[] args) {
        Timer timer = new Timer();

        // Planifier une tâche qui s'exécute toutes les secondes
        CompteARebours compteARebours = new CompteARebours();
        CompteARebours.CompteAReboursTask task = compteARebours.new CompteAReboursTask();
    }

    /**
     * Méthode qui permet de récupérer le temps restant du compte à rebours.
     * Pour cela elle calcule le nombre de minutes et de secondes restantes et
     * retourne un string sous la forme "mm:ss".
     * 
     * @return Le temps restant du compte à rebours
     */
    public String getCompteARebours() {
        int minutes = tempsRestant / 60;
        int secondes = tempsRestant % 60;
        //System.out.println(String.format("%02d:%02d", minutes, secondes));
        return String.format("%02d:%02d", minutes, secondes);

    }

    /**
     * Classe qui permet de créer une tâche qui s'exécute toutes les secondes.
     * Elle permet de mettre à jour le temps restant du compte à rebours.
     */
    public class CompteAReboursTask extends TimerTask {
        public String compteARebours;

        @Override
        public void run() {
            if (tempsRestant > 0) {
                compteARebours = getCompteARebours();
                // System.out.println(compteARebours);
                tempsRestant--;
            } else {
                annulerCompteARebours();
            }
        }

        /**
         * Méthode qui permet de récupérer le temps restant du compte à rebours.
         * 
         * @return Le temps restant du compte à rebours
         */
        public int getTempsRestant() {
            return tempsRestant;
        }

        /**
         * Méthode qui permet de récupérer le temps restant du compte à rebours.
         * Pour cela elle calcule le nombre de minutes et de secondes restantes et
         * retourne un string sous la forme "mm:ss".
         * 
         * @return Le temps restant du compte à rebours
         */
        public String getCompteARebours() {
            int minutes = tempsRestant / 60;
            int secondes = tempsRestant % 60;
            return String.format("%02d:%02d", minutes, secondes);

        }
    }

    /**
     * Méthode qui permet d'annuler le compte à rebours. Elle est appelée lorsque le
     * temps restant est égal à 0 (donc que le compte à rebours est terminé). 
     */
    private static void annulerCompteARebours() {
        System.exit(0); // Terminer le programme après la fin du compte à rebours
    }

}
