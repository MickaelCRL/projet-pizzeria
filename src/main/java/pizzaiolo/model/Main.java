import java.awt.BorderLayout;

import javax.swing.*;



public class Main {
    public static void main(String[] args) {
        JFrame fenetre = new JFrame("Pizzas à préparer");
        fenetre.setSize(700, 500);

        JPanel topPanel = new JPanel();
        topPanel.setLayout(new BorderLayout());
        fenetre.getContentPane().add(topPanel);

        fenetre.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);

        fenetre.add(new TableauPanel(),BorderLayout.CENTER);
        
        JTable table = new JTable();
        JScrollPane  scrollPane = new JScrollPane(table);
        topPanel.add(scrollPane,BorderLayout.CENTER);


        fenetre.setVisible(true);

    }
        }

