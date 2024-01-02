import java.awt.BorderLayout;
import java.awt.event.WindowAdapter;
import java.awt.event.WindowEvent;
import java.util.ArrayList;

import javax.swing.*;

import com.mysql.cj.x.protobuf.MysqlxDatatypes.Array;

public class Main {

    public static void main(String args[]) {

        // Initialisation de la fenêtre graphique
        ArrayList<pizza> pizzaList = new ArrayList<pizza>();
        OutilsJDBC o = new OutilsJDBC();
        controllerPizza c = new controllerPizza(o, pizzaList);
        FenetrePizzaiolo f = new FenetrePizzaiolo(o, c);

        SwingUtilities.invokeLater(() -> {

            f.setVisible(true);

            f.addWindowListener(new WindowAdapter() {
                public void windowClosing(WindowEvent e) {
                    // Termine l'application et ferme la connexion lorsque la fenêtre est fermée
                    o.closeConnection(f.maConnection);
                    System.exit(0);
                }
            });

            // Utilisation d'un timer pour mettre à jour les comptes à rebours toutes les
            // secondes
            Timer timer = new Timer(1000, e -> {
                for (int i = 0; i < f.data.length; i++) {
                    f.updateCountdown(f.data, i); // Mettre à jour le tableau avec le compte à rebours
                }
            });
            timer.start();

            // Initialiser un thread qui va mettre à jour les données du tableau toutes les
            // 10 secondes
            updateThread t = new updateThread(f, f.maConnection, o, f.data);
            t.start();

        });
    }
}
