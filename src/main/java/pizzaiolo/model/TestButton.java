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


class TestJButton extends JFrame
{
    private JPanel topPanel;
    private JTable table;
    private JScrollPane scrollPane;
    private String[] columns = new String[3];
    private String[][] data;
    JButton button = new JButton();

    CompteARebours.CompteAReboursTask cab;

    DefaultTableModel model;

    DefaultTableModel UpdateModel;

    String cabString;

    ArrayList<String> nomPizzaList;
    ArrayList<String> ingredientsPizzaList;

    static String url="jdbc:mysql://192.70.36.54/saes3pizzeria?user=saes3pizzeria&password=]bBWo[QUw65[]0FG&zeroDateTimeBehavior=convertToNull";

    public void getNomPizza(){ //TODO : récupérer les ingrédients des pizzas dans la base de données
       nomPizzaList = new ArrayList<>();
       ingredientsPizzaList = new ArrayList<>();
        OutilsJDBC o = new OutilsJDBC();
        Connection maConnection = o.openConnection(url);
        ResultSet monResultat = o.exec1Requete("SELECT * FROM Pizza", maConnection, 0);
        try {
            while (monResultat.next()) {
                String nomPizza = monResultat.getString(2);
                String ingredientPizza = monResultat.getString(4);
                nomPizzaList.add(nomPizza);
                ingredientsPizzaList.add(ingredientPizza);
            }
        } catch (SQLException e) {
            System.out.println("Erreur conçernant le ResultSet");
        }

        o.closeConnection(maConnection);

        //mettre les données de l'ArrayList dans le tableau pour le modèle du JTable
        data = new String[nomPizzaList.size()][3];
        System.out.println(nomPizzaList.size());
        for(int i = 0; i < nomPizzaList.size(); i++){
            data[i][0] = nomPizzaList.get(i);
            data[i][1] = ingredientsPizzaList.get(i);
            data[i][2] = "15:00";
        }
    }




    public TestJButton()
    {


        //paramètres de la fenêtre
        setTitle("Pizza Paradise - interface du pizzaïolo");
        setSize(500,350);
        setLayout(new BorderLayout());
        getContentPane().add(new PanelTitre(),BorderLayout.NORTH);
        this.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);


        topPanel = new JPanel();
        topPanel.setLayout(new BorderLayout());
        topPanel.setBorder(BorderFactory.createEmptyBorder(10, 10, 10, 10));
        topPanel.invalidate();
        getContentPane().add(topPanel);
        columns = new String[] {"Nom de la pizza", "Ingrédients","Temps restant", "Action"};
        java.util.Timer timer = new java.util.Timer();
        // Planifier une tâche qui s'exécute toutes les secondes
        cab = new CompteARebours.CompteAReboursTask();
        timer.scheduleAtFixedRate(cab, 0, 1000);
        cabString = cab.compteARebours;
        System.out.println("INITIAL : "+cabString);


        //data = new String[][]{
                //{"Pizza 1","Fromage et jambons","15:00"},
                //{"Pizza 2","Fromage et jambons","15:00"},
                //{"Pizza 3","Fromage et jambons","15:00"}
       // };

        getNomPizza();

        model = new DefaultTableModel(data,columns){
            @Override
            public boolean isCellEditable(int row, int column) {
                Object value = getValueAt(row, column);
                if (getColumnName(column).equals("Action")) {
                    return true; // Permettre d'appuyer sur les boutons, impossible si on désactive la modification
                }
                return false;
            }
        };
        table = new JTable();
        table.setModel(model);
        table.getColumn("Action").setCellRenderer(new ButtonRenderer());
        table.getColumn("Action").setCellEditor(new ButtonEditor(new JCheckBox()));
        scrollPane = new JScrollPane(table);
        topPanel.add(scrollPane,BorderLayout.CENTER);

        button.addActionListener(
                new ActionListener()
                {
                    public void actionPerformed(ActionEvent event) {
                        int choix = JOptionPane.showConfirmDialog(null, "Voulez-vous valider la préparation de cette pizza ?", "Validation de la préparation", JOptionPane.YES_NO_OPTION);

                        if (choix == JOptionPane.YES_OPTION) {
                            System.out.println(table.getSelectedRow());
                            data = removeRowFromData(data,table.getSelectedRow());
                            ((DefaultTableModel)table.getModel()).removeRow(table.getSelectedRow());

                        } else {
                            // Code à exécuter si l'utilisateur choisit "Non" ou ferme la boîte de dialogue
                            // Ajoutez le code correspondant ici
                        }
                    }

                }
        );

    }

    class ButtonRenderer extends JButton implements TableCellRenderer
    {
        public ButtonRenderer() {
            setOpaque(true);
        }

        public Component getTableCellRendererComponent(JTable table, Object value,
                                                       boolean isSelected, boolean hasFocus, int row, int column) {
            setText((value == null) ? "Valider" : value.toString());
            return this;
        }
    }

    class ButtonEditor extends DefaultCellEditor
    {
        private String label;

        public ButtonEditor(JCheckBox checkBox)
        {
            super(checkBox);
        }

        public Component getTableCellEditorComponent(JTable table, Object value,
                                                     boolean isSelected, int row, int column)
        {
            label = (value == null) ? "Valider" : value.toString();
            button.setText(label);
            return button;
        }

        public Object getCellEditorValue()
        {
            return new String(label);
        }
    }

    public static void main(String args[]) {
        SwingUtilities.invokeLater(() -> {
            TestJButton f = new TestJButton();
            f.setVisible(true);

            // Use a Timer to update the countdown every second
            Timer timer = new Timer(1000, e -> f.updateCountdown());
            timer.start();
        });
    }


    private void updateCountdown() {
        int selectedRow = table.getSelectedRow();
        cabString = cab.compteARebours;
        System.out.println("UPDATE : " + cabString);

        for (int i = 0; i < data.length; i++) {
            data[i][2] = cabString;
        }
        //data[0][2] = cabString;
        //data[1][2] = cabString;
        //data[2][2] = cabString;
        UpdateModel = new DefaultTableModel(data,columns){
            @Override
            public boolean isCellEditable(int row, int column) {
                Object value = getValueAt(row, column);
                System.out.println(value);

                if (getColumnName(column).equals("Action")) {
                    return true; // Permettre d'appuyer sur les boutons, impossible si on désactive la modification
                }
                return false;
            }
        };

        table.setModel(UpdateModel);
        //table.getColumn("Action").setCellRenderer(new ButtonRenderer());
        table.getColumn("Action").setCellRenderer(new ButtonRenderer());
        table.getColumn("Action").setCellEditor(new ButtonEditor(new JCheckBox()));
        if (selectedRow != -1) {
            table.setRowSelectionInterval(selectedRow, selectedRow);
        }
    }
    private static String[][] removeRowFromData(String[][] originalArray, int rowIndexToRemove) {
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
            // Si l'index est invalide, retournez le tableau original sans modification
            return originalArray;
        }
    }

}