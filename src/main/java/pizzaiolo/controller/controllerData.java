import java.util.ArrayList;

public class controllerData {

    private modelData MD;


    /**
     * Constructeur de la classe controllerData.
     * 
     * @param MD Le modelData
     */
    public controllerData(modelData MD) {
        this.MD = MD;
    }

    public void removeRowFromData(String[][] originalArray, int rowIndexToRemove, ArrayList<pizza> pizzaList) {
        MD.removeRowFromData(originalArray, rowIndexToRemove, pizzaList);
    }
    
}
