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
    private modelData MD = new modelData();
    private controllerData CD = new controllerData(MD);
    // Elements de la fenêtre graphique
    private JPanel topPanel; // panel du haut qui affiche le titre de la pizzeria sur fond noir
    private JTable table;
    private JScrollPane scrollPane; // scrollPane qui contiendra le tableau des pizzas à préparer
    JButton button = new JButton(); // bouton de validation de la préparation d'une pizza
    DefaultTableModel model; // modèle du JTable pour le tableau des pizzas à préparer
    DefaultTableModel UpdateModel; // mise à jour du modèle

    // Données du tableau des pizzas à préparer
    private String[] columns = new String[5]; // colonnes du tableau des pizzas à préparer
    public String[][] data; // données du tableau des pizzas à préparer

    // Outils de connexion à la base de données
    public OutilsJDBC o; // outil de connexion à la base de données
    public Connection maConnection; // connexion à la base de données

    // Compte à rebours
    String cabString; // compte à rebours sous forme de String pour l'afficher dans le tableau

    // Liste des pizzas à préparer
    ArrayList<pizza> pizzaList; // liste des pizzas à préparer
    
    static String url = "jdbc:mysql://192.70.36.54/saes3pizzeria?user=saes3pizzeria&password=]bBWo[QUw65[]0FG&zeroDateTimeBehavior=convertToNull";

    /**
     * Récupère les pizzas, leurs ingrédients et leurs quantités dans la base de
     * données
     * et appelle la fonction updateDataFromDataBase() pour initialiser le tableau
     */
    public void getPizzaInfos() {
        this.o = new OutilsJDBC();
        maConnection = o.openConnection(url);
        updateDataFromDataBase(maConnection, o);
    }

    /**
     * Constructeur de la fenêtre graphique, initialise les éléments graphiques et
     * les données du tableau
     * 
     * @param o outil de connexion à la base de données
     */
    public FenetrePizzaiolo(OutilsJDBC o) {
        this.o = o;
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
        columns = new String[] {"Nom de la pizza", "Ingrédients", "Quantité à préparé", "Temps restant", "Action", "Id" };

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
        cacherColonneID();
        table.getColumn("Action").setCellRenderer(new ButtonRenderer());
        table.getColumn("Action").setCellEditor(new ButtonEditor(new JCheckBox(), button));
        scrollPane = new JScrollPane(table);
        topPanel.add(scrollPane, BorderLayout.CENTER);

        button.addActionListener(
                new ActionListener() {
                    public void actionPerformed(ActionEvent event) {
                        int choix = JOptionPane.showConfirmDialog(null,
                                "Voulez-vous valider la préparation de cette pizza ?", "Validation de la préparation",
                                JOptionPane.YES_NO_OPTION);

                        if (choix == JOptionPane.YES_OPTION) {
                        	if(Integer.valueOf(table.getModel().getValueAt(table.getSelectedRow(), 2).toString())==1) {
                            // Supprimer la ligne du tableau et mettre à jour la base de données
                            data = MD.removeRowFromData(data, table.getSelectedRow(), pizzaList);
                            o.terminerPizza(table.getModel().getValueAt(table.getSelectedRow(), 5).toString(),
                                    maConnection);
                            ((DefaultTableModel) table.getModel()).removeRow(table.getSelectedRow());
                        	}
                        	else {
                        		// Décrémenter la quantité à préparer du tableau et de la base de donnée 
                        		int quantiteUpdate = Integer.valueOf(table.getModel().getValueAt(table.getSelectedRow(), 2).toString());
                        		quantiteUpdate--;
                        		data[table.getSelectedRow()][2] = String.valueOf(quantiteUpdate);
                        		int idPizza = Integer.valueOf(table.getModel().getValueAt(table.getSelectedRow(), 5).toString());
                        		for(pizza p : pizzaList){
                        			if (p.getId()==idPizza) {
                        				p.setQuantiteAPreparer(quantiteUpdate);
                        			}
                        			
                        		}
                        		o.updateQuantitePizza(idPizza,quantiteUpdate,maConnection);                        		
                        	}

                        } else {
                            // Ne rien faire ici
                        }
                    }
                });
    }

    /**
     * Fonction pour mettre à jour le compte à rebours du tableau.
     * Elle parcourt la liste des pizzas obtenue de la base de donnée et met à jour
     * le compte à rebours de la pizza correspondante. Si la pizza n'a pas de compte
     * à rebours,
     * elle en crée un. Pour mettre à jour le tableau, elle crée un nouveau modèle
     * de tableau
     * avec les nouvelles données et remplace l'ancien modèle par le nouveau.
     * 
     * @param data données du tableau
     * @param Row  ligne du tableau à mettre à jour
     */
    public void updateCountdown(String[][] data, int Row) {
        int selectedRow = table.getSelectedRow();
        CompteARebours compteARebours;
        CompteARebours.CompteAReboursTask cab = null;

        // Recherche de la pizza correspondante dans la liste des pizzas
        for (int i = 0; i < pizzaList.size(); i++) {
            if (String.valueOf(pizzaList.get(i).getId()).equals(data[Row][5])) {
                if (pizzaList.get(i).getCab() == null) {
                    // Planifier une tâche qui s'exécute toutes les secondes
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
                    compteARebours = pizzaList.get(i).getCab();
                    cabString = compteARebours.getCompteARebours();
                    data[Row][3] = cabString;
                }
            }

        }
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
        UpdateModel.setDataVector(data, columns);
        UpdateModel.fireTableDataChanged();
        table.getColumn("Action").setCellRenderer(new ButtonRenderer());
        table.getColumn("Action").setCellEditor(new ButtonEditor(new JCheckBox(), button));
        if (selectedRow != -1) {
            table.setRowSelectionInterval(selectedRow, selectedRow);
        }
    }

    /**
     * Fonction pour mettre à jour les données du tableau.
     * Elle récupère les données de la base de données et les met dans la liste de
     * pizza puis dans le tableau.
     * Elle met ensuite à jour le modèle du tableau avec les nouvelles données.
     * Cette fonction est appelée une première fois dans le constructeur de la
     * fenêtre,
     * puis toutes les 10 secondes par le thread updateThread.
     * 
     * @param maConnection connexion à la base de données
     * @param o            outil de connexion à la base de données
     */
    public void updateDataFromDataBase(Connection maConnection, OutilsJDBC o) {
        // Mettre à jour les données du tableau avec les données de la base de données
        ResultSet monResultatUpdate = o.exec1Requete("SELECT * FROM Pizza WHERE etatPizza=false", maConnection, 0);
        boolean pizzaExists = false;
        if (pizzaList == null)
            pizzaList = new ArrayList<pizza>();
          
        try {
            while (monResultatUpdate.next()) {
                pizzaExists = false;
                int idPizza = monResultatUpdate.getInt(1); //récupérer l'id de la pizza pour les doublons de noms
                String nomPizza = monResultatUpdate.getString(2);
                String ingredientPizza = monResultatUpdate.getString(4);
                int quantiteAPreparer = monResultatUpdate.getInt(5);
                // tester si la pizza est déjà dans la pizzaList
                for (pizza elt : pizzaList) {
                    if (elt.getId()==idPizza) {
                        pizzaExists = true; // la pizza existe déjà dans la liste
                    }
                }
                if (!pizzaExists) { // si la pizza n'existe pas dans la liste, on l'ajoute
                    pizzaList.add(new pizza(idPizza, nomPizza, ingredientPizza, quantiteAPreparer, null));
                }
            }
        } catch (SQLException e) {
            System.out.println("Erreur conçernant le ResultSet");
        }
        data = new String[pizzaList.size()][6];
        // mettre les données de l'ArrayList dans le tableau pour le modèle du JTable
        for (int i = 0; i < pizzaList.size(); i++) {
            data[i][0] = pizzaList.get(i).getNom();
            data[i][1] = pizzaList.get(i).getIngredients();
            data[i][2] = String.valueOf(pizzaList.get(i).getQuantiteAPreparer());
            if (pizzaList.get(i).getCab() != null) {
                data[i][3] = pizzaList.get(i).getCab().getCompteARebours();
            } else {
                data[i][3] = null;
            }
            data[i][5] = String.valueOf(pizzaList.get(i).getId());
        }
        
        // le modèle du JTable est déjà mis à jour toutes les secondes à l'aide de data
        // dans la méthode updateCountdown()
    }
    
    public JTable getTable() {
    	return table;
    }
    
    public void cacherColonneID() {
    	table.getColumnModel().getColumn(5).setMaxWidth(0);
    	table.getColumnModel().getColumn(5).setMinWidth(0);
    	table.getColumnModel().getColumn(5).setWidth(0);
    	table.getTableHeader().getColumnModel().getColumn(5).setMaxWidth(0);
    	table.getTableHeader().getColumnModel().getColumn(5).setMinWidth(0);
    	table.getTableHeader().getColumnModel().getColumn(5).setWidth(0);
    }
}