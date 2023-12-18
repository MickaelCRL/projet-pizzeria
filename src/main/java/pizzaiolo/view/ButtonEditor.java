import javax.swing.*;
import java.awt.*;

class ButtonEditor extends DefaultCellEditor
{
    private String label;

    JButton button;

    public ButtonEditor(JCheckBox checkBox, JButton b)
    {
        super(checkBox);
        this.button = b;
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