import javax.swing.*;
import java.awt.*;
import java.util.ArrayList;
import java.util.Arrays;

public class vueLivreur extends JFrame {

    public vueLivreur(ArrayList<PanelCommande> commandes) {
        setTitle("Liste des livraisons à effectuer");
        setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        setLayout(new BorderLayout());

        JPanel panelLivraisons = new JPanel(new GridLayout(0, 1));
        JScrollPane scrollPane = new JScrollPane(panelLivraisons);
        add(scrollPane, BorderLayout.CENTER);

        // Ajout des panels de commande à la vue
        for (PanelCommande commande : commandes) {
            panelLivraisons.add(commande);
        }

        pack();
        setLocationRelativeTo(null); // Centrer la fenêtre
        setVisible(true);
    }

    public static void main(String[] args) {
        // Exemple d'utilisation
        ArrayList<PanelCommande> commandes = new ArrayList<>();
        commandes.add(new PanelCommande(1, "Client1", "Adresse1", "123456789",
                new ArrayList<>(Arrays.asList("Pizza1", "Pizza2")), "Instructions", "En cours"));
        commandes.add(new PanelCommande(2, "Client2", "Adresse2", "987654321",
                new ArrayList<>(Arrays.asList("Pizza3", "Pizza4")), "Instructions", "En cours"));

        SwingUtilities.invokeLater(() -> new vueLivreur(commandes));
    }
}