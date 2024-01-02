import java.awt.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.sql.Connection;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import javax.swing.*;
import javax.swing.table.DefaultTableModel;
import javax.swing.table.TableCellRenderer;
import java.awt.event.WindowAdapter;
import java.awt.event.WindowEvent;

class FenetrePizzaiolo extends JFrame {
    // Elements de la fenêtre graphique
    private JPanel topPanel; // panel du haut qui affiche le titre de la pizzeria sur fond noir
    private JTable table;
    private JScrollPane scrollPane; // scrollPane qui contiendra le tableau des pizzas à préparer
    JButton button = new JButton(); // bouton de validation de la préparation d'une pizza
    DefaultTableModel model; // modèle du JTable pour le tableau des pizzas à préparer
    DefaultTableModel UpdateModel; // mise à jour du modèle

    // Données du tableau des pizzas à préparer
    private String[] columns = new String[4]; // colonnes du tableau des pizzas à préparer
    public String[][] data; // données du tableau des pizzas à préparer

    // Outils de connexion à la base de données
    public OutilsJDBC o; // outil de connexion à la base de données
    public Connection maConnection; // connexion à la base de données

    // Compte à rebours
    String cabString; // compte à rebours sous forme de String pour l'afficher dans le tableau

    // Liste des pizzas à préparer
    ArrayList<pizza> pizzaList; // liste des pizzas à préparer

    private controllerPizza c;

    static String url = "jdbc:mysql://192.70.36.54/saes3pizzeria?user=saes3pizzeria&password=]bBWo[QUw65[]0FG&zeroDateTimeBehavior=convertToNull";

    /**
     * Récupère les pizzas, leurs ingrédients et leurs quantités dans la base de données
     * et appelle la fonction updateDataFromDataBase() pour initialiser le tableau
     */
    public void getPizzaInfos() { 
        this.o = new OutilsJDBC();
        maConnection = o.openConnection(url);
        updateDataFromDataBase(maConnection, o, data);
    }

    /**
     * Constructeur de la fenêtre graphique, initialise les éléments graphiques et les données du tableau
     * @param o outil de connexion à la base de données
     */
    public FenetrePizzaiolo(OutilsJDBC o, controllerPizza c) {
        this.o = o;
        this.c = c;
        this.pizzaList = c.getPizzaList();
        // Paramètres de la fenêtre
        setTitle("Pizza Paradise - interface du pizzaïolo");
        setSize(1500, 400);
        setLayout(new BorderLayout());
        getContentPane().add(new PanelTitre(), BorderLayout.NORTH);
        this.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);

        // Initialisation du panel contenant le tableau des pizzas à préparer
        topPanel = new JPanel();
        topPanel.setLayout(new BorderLayout());
        topPanel.setBorder(BorderFactory.createEmptyBorder(10, 10, 10, 10));
        topPanel.invalidate();
        getContentPane().add(topPanel);

        // Initialisation des colonnes du tableau des pizzas à préparer
        columns = new String[] { "Nom de la pizza", "Ingrédients", "Quantité à préparé", "Temps restant", "Action" };

        // Initialisation des données du tableau des pizzas à préparer
        getPizzaInfos();

        // Initialisation du model du tableau des pizzas à préparer
        model = new DefaultTableModel(data, columns) {
            @Override
            public boolean isCellEditable(int row, int column) {
                Object value = getValueAt(row, column);
                if (getColumnName(column).equals("Action")) {
                    return true; // Permettre d'appuyer sur les boutons, impossible si on désactive la
                                 // modification
                }
                return false;
            }
        };

        // Paramètres du tableau des pizzas à préparer
        table = new JTable();
        table.setModel(model);
        table.getColumn("Action").setCellRenderer(new ButtonRenderer());
        table.getColumn("Action").setCellEditor(new ButtonEditor(new JCheckBox(),button));
        scrollPane = new JScrollPane(table);
        topPanel.add(scrollPane, BorderLayout.CENTER);

        // Ajout d'un listener sur le bouton de validation de la préparation d'une pizza
        button.addActionListener(
                new ActionListener() {
                    public void actionPerformed(ActionEvent event) {
                        int choix = JOptionPane.showConfirmDialog(null,
                                "Voulez-vous valider la préparation de cette pizza ?", "Validation de la préparation",
                                JOptionPane.YES_NO_OPTION);

                        if (choix == JOptionPane.YES_OPTION) {
                            // Supprimer la ligne du tableau et mettre à jour la base de données
                            data = removeRowFromData(data, table.getSelectedRow());
                            o.terminerPizza(table.getModel().getValueAt(table.getSelectedRow(), 0).toString(), maConnection);
                            ((DefaultTableModel) table.getModel()).removeRow(table.getSelectedRow());

                        } else {
                            // Ne rien faire ici 
                        }
                    }
                });
    }
    /**
     * Fonction pour mettre à jour le compte à rebours du tableau.
     * Elle parcourt la liste des pizzas obtenue de la base de donnée et met à jour
     * le compte à rebours de la pizza correspondante. Si la pizza n'a pas de compte à rebours,
     * elle en crée un. Pour mettre à jour le tableau, elle crée un nouveau modèle de tableau
     * avec les nouvelles données et remplace l'ancien modèle par le nouveau.
     * @param data données du tableau
     * @param Row ligne du tableau à mettre à jour
     */
    public void updateCountdown(String[][] data, int Row) {
        int selectedRow = table.getSelectedRow();
        CompteARebours compteARebours;
        CompteARebours.CompteAReboursTask cab = null;

        // Recherche de la pizza correspondante dans la liste des pizzas
        for (int i = 0; i < pizzaList.size(); i++) {
            if (pizzaList.get(i).getNom().equals(data[Row][0])) {
                if (pizzaList.get(i).getCab() == null) {
                    // La pizza n'a pas encore de compte à rebours
                    // Créer une tâche de timer qui s'exécute toutes les secondes
                    compteARebours = new CompteARebours();
                    java.util.Timer timerC = new java.util.Timer();
                    cab = new CompteARebours().new CompteAReboursTask();
                    cab = compteARebours.new CompteAReboursTask();
                    timerC.scheduleAtFixedRate(cab, 0, 1000);
                    pizzaList.get(i).setCab(compteARebours);
                    // Mettre à jour le tableau avec le compte à rebours
                    cabString = String.valueOf(cab.getCompteARebours());
                    data[Row][3] = cabString;
                } else {
                    // La pizza a déjà un compte à rebours
                    // Il suffit donc de mettre à jour ce compte à rebours
                    compteARebours = pizzaList.get(i).getCab();
                    cabString = compteARebours.getCompteARebours();
                    data[Row][3] = cabString;
                }
            }

        }
        // Mettre à jour le modèle du tableau
        UpdateModel = new DefaultTableModel(data, columns) {
            @Override
            public boolean isCellEditable(int row, int column) {
                Object value = getValueAt(row, column);
                if (getColumnName(column).equals("Action")) {
                    return true; // Permettre d'appuyer sur les boutons, impossible si on désactive la
                                 // modification
                }
                return false;
            }
        };
        table.setModel(UpdateModel);
        // Signifier au modèle que les données ont changé
        UpdateModel.setDataVector(data, columns);
        UpdateModel.fireTableDataChanged();
        // Paramètres du tableau
        table.getColumn("Action").setCellRenderer(new ButtonRenderer());
        table.getColumn("Action").setCellEditor(new ButtonEditor(new JCheckBox(),button));
        if (selectedRow != -1) {
            table.setRowSelectionInterval(selectedRow, selectedRow);
        }
    }

     /**
     * Fonction pour mettre à jour les données du tableau.
     * Elle récupère les données de la base de données et les met dans la liste de pizza puis dans le tableau.
     * Elle met ensuite à jour le modèle du tableau avec les nouvelles données.
     * Cette fonction est appelée une première fois dans le constructeur de la fenêtre, 
     * puis toutes les 10 secondes par le thread updateThread.
     * @param maConnection connexion à la base de données
     * @param o outil de connexion à la base de données
     */
    public void updateDataFromDataBase(Connection maConnection, OutilsJDBC o, String[][] data) {
        // Récupérer les données de la base de données
        ResultSet monResultatUpdate = o.exec1Requete("SELECT * FROM Pizza WHERE etatPizza=false", maConnection, 0);
        boolean pizzaExists = false;
        if (pizzaList == null)
            pizzaList = new ArrayList<pizza>(); // Initialiser la liste des pizzas si elle n'existe pas
        try {
            while (monResultatUpdate.next()) {
                pizzaExists = false;
                String nomPizza = monResultatUpdate.getString(2);
                String ingredientPizza = monResultatUpdate.getString(4);
                int temp = monResultatUpdate.getInt(5);
                String quantiteAPreparer = String.valueOf(temp);
                // Tester si la pizza est déjà dans la pizzaList
                for (pizza elt : pizzaList) {
                    if ((elt.getNom().equals(nomPizza))) {
                        pizzaExists = true; // La pizza existe déjà dans la liste
                    }
                }
                if (!pizzaExists) { // Si la pizza n'existe pas dans la liste, on l'ajoute
                    pizzaList.add(new pizza(nomPizza, ingredientPizza, quantiteAPreparer, null));
                }
            }
        } catch (SQLException e) {
            System.out.println("Erreur conçernant le ResultSet");
        }
        // Créer ou recréer le tableau des pizzas à préparer
        data = new String[pizzaList.size()][4];
        // Mettre les données de l'ArrayList dans le tableau pour le modèle du JTable
        for (int i = 0; i < pizzaList.size(); i++) {
            data[i][0] = pizzaList.get(i).getNom();
            data[i][1] = pizzaList.get(i).getIngredients();
            data[i][2] = pizzaList.get(i).getQuantiteAPreparer();
            if (pizzaList.get(i).getCab() != null) {
                data[i][3] = pizzaList.get(i).getCab().getCompteARebours();
            } else {
                data[i][3] = null;
            }
        }
        // Le modèle du JTable est déjà mis à jour toutes les secondes à l'aide de data
        // dans la méthode updateCountdown() donc pas besoin de le mettre à jour ici
    }
    
   

    /**
     * Fonction pour supprimer une ligne du tableau.
     * Elle supprime la pizza de la liste des pizzas à préparer et met à jour le tableau.
     * @param originalArray tableau originel des pizzas à préparer
     * @param rowIndexToRemove ligne du tableau à supprimer
     * @return le tableau des pizzas à préparer sans la ligne supprimée
     */
    private String[][] removeRowFromData(String[][] originalArray, int rowIndexToRemove) {
        String nomPizzaASupp = originalArray[rowIndexToRemove][0];
        // Supprimer la pizza de la liste des pizzas
        for (int i = 0; i < pizzaList.size(); i++) {
            if (pizzaList.get(i).getNom().equals(nomPizzaASupp)) {
                pizzaList.remove(i);
                for (pizza elt : pizzaList) {
                    System.out.println(elt.getNom());
                }
            }
        }
        // Supprimer la ligne du tableau
        if (rowIndexToRemove >= 0 && rowIndexToRemove < originalArray.length) {
            String[][] newArray = new String[originalArray.length - 1][originalArray[0].length];
            int newIndex = 0;

            for (int i = 0; i < originalArray.length; i++) {
                if (i != rowIndexToRemove) {
                    newArray[newIndex++] = originalArray[i];
                }
            }

            return newArray;
        } else {
            // Si l'index est invalide, retourne le tableau original sans modification
            return originalArray;
        }
    }

   
}
