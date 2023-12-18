import java.util.Timer;
import java.util.TimerTask;

public class CompteARebours {

    private static int tempsRestant = 15 * 60; // 15 minutes en secondes

    public static void main(String[] args) {
        Timer timer = new Timer();

        // Planifier une tâche qui s'exécute toutes les secondes
        timer.scheduleAtFixedRate(new CompteAReboursTask(), 0, 1000);
    }

    public static String getCompteARebours() {
        int minutes = tempsRestant / 60;
        int secondes = tempsRestant % 60;
        System.out.println(String.format("%02d:%02d", minutes, secondes));
        return String.format("%02d:%02d", minutes, secondes);

    }

    static class CompteAReboursTask extends TimerTask {
        public static String compteARebours;

        @Override
        public void run() {
            if (tempsRestant > 0) {
                compteARebours = getCompteARebours();
                //System.out.println(compteARebours);
                tempsRestant--;
            } else {
                annulerCompteARebours();
            }
        }
    }

    private static void annulerCompteARebours() {
        System.out.println("Le compte à rebours de 15 minutes est terminé.");
        System.exit(0); // Terminer le programme après la fin du compte à rebours
    }
}
