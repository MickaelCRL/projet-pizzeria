import javax.swing.*;
import java.awt.*;

/*
 * Classe qui permet de créer le panel du titre de l'application.
 */
public class PanelTitre extends JPanel {
    /**
     * Constructeur de la classe PanelTitre.
     */
    public PanelTitre() {
        super();
        setPreferredSize(new Dimension(500, 50));
        this.setBackground(Color.BLACK);
        this.setLayout(new FlowLayout());
        this.setBorder(BorderFactory.createEmptyBorder(10, 10, 10, 10));
        this.invalidate();

        JLabel titre = new JLabel("Pizza Paradise");
        titre.setHorizontalAlignment(JLabel.CENTER);
        titre.setForeground(Color.YELLOW);
        this.add(titre);
    }
}
