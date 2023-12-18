import java.awt.*;
import java.awt.event.*;
import javax.swing.*;
import javax.swing.table.*;
import javax.swing.table.DefaultTableCellRenderer;

public class TableauPanel extends JTable {

    public TableauPanel() {

        JButton button = new JButton();

        this.setPreferredSize(new Dimension(300,250));

        Object[][] donnees = {
                {"Pizza 1", "Fromage et jambons", "15 min",new JButton("Pizza faite")},
                {"Pizza 2", "Fromage et jambons", "15 min",new JButton("Pizza faite")},
                {"Pizza 3", "Fromage et jambons", "15 min",new JButton("Pizza faite")},
        };

        String[] entetes = {"Nom de la pizza", "Ingrédients", "Temps restant","Valider la préparation"};



        DefaultTableModel model = new DefaultTableModel(donnees,entetes);
        JTable tableau = new JTable();
        tableau.setModel(model);

        tableau.getColumn("Valider la préparation").setCellRenderer(new ButtonRenderer());
        tableau.getColumn("Valider la préparation").setCellEditor(new ButtonEditor(new JCheckBox(),button));

        tableau.setAutoResizeMode(JTable.AUTO_RESIZE_OFF);
        tableau.getColumnModel().getColumn(0).setPreferredWidth(50);
        tableau.getColumnModel().getColumn(1).setPreferredWidth(250);
        tableau.getColumnModel().getColumn(2).setPreferredWidth(50);
        tableau.setRowHeight(80);

        System.out.println("aaaaaaa");

        this.add(tableau);

    }



}
