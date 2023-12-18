import javax.swing.*;
import java.awt.*;
import java.util.ArrayList;

// Classe PanelCommande pour chaque commande à afficher
class PanelCommande extends JPanel {
    public PanelCommande(int numeroCommande, String nomClient, String adresseLivraison, String telephoneClient,
                         ArrayList<String> pizzas, String instructionsLivraison, String etatLivraison) {
        setLayout(new BorderLayout());

        // Création des éléments pour afficher les détails de la commande
        JLabel labelNumero = new JLabel("N° de commande : " + numeroCommande);
        JLabel labelNomClient = new JLabel("Nom du client : " + nomClient);
        JLabel labelAdresse = new JLabel("Adresse de livraison : " + adresseLivraison);
        JLabel labelTelephone = new JLabel("Téléphone : " + telephoneClient);
        JLabel labelPizzas = new JLabel("Pizzas à livrer : " + String.join(", ", pizzas));
        JLabel labelInstructions = new JLabel("Instructions de livraison : " + instructionsLivraison);
        JLabel labelEtatLivraison = new JLabel("État de la livraison : " + etatLivraison);

        // Création des boutons "Livrer" et "Retard"
        JButton boutonLivrer = new JButton("Livrer");
        JButton boutonRetard = new JButton("Retard");

        // Ajout des éléments au panel
        add(labelNumero, BorderLayout.NORTH);
        add(new JSeparator(), BorderLayout.CENTER); // Trait séparateur
        add(labelNomClient);
        add(labelAdresse);
        add(labelTelephone);
        add(labelPizzas);
        add(labelInstructions);
        add(labelEtatLivraison);
        add(boutonLivrer);
        add(boutonRetard);

        setBorder(BorderFactory.createEtchedBorder());
    }
}